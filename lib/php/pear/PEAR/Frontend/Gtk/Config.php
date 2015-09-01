<?php
/*
  +----------------------------------------------------------------------+
  | PHP Version 4                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2003 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 2.02 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available at through the world-wide-web at                           |
  | http://www.php.net/license/2_02.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Alan Knowles <alan@akbkhome.com>                             |
  +----------------------------------------------------------------------+

  $Id: Config.php,v 1.5 2003/01/04 11:55:55 mj Exp $
*/

/**
 * Gtk Frontend - Configuration
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */


class PEAR_Frontend_Gtk_Config {
    var $ui; // main interface
    /**
    * The GtkLabel that shows the help config
    *
    * @var object GtkLabel configuration help text 
    * @access private
    */
    var $help;
       /**
    * The GtkNotebook that has all the tabs
    *
    * @var object Gtknotebook
    * @access private
    */
    var $notebook;
   /**
    * The Save GtkButton
    *
    * @var object GtkButton
    * @access private
    */
    var $save;
    /**
    * The Reset GtkButton
    *
    * @var object GtkButton
    * @access private
    */
    var $reset;
    /**
    * The New configuration 
    *
    * @var array asssociative key=>value
    * @access private
    */
    var $NewConfig;
    /**
    * Constructor
    *
    * @param array see config-show for more details.
    */
    
    function PEAR_Frontend_Gtk_Config(&$ui) {
        $this->ui = &$ui;
    }
    
    /**
    * Load Configuration into widgets (Initialize)
    *
    * Clear current config tabs, and calls the Command Show-config
    *
    * @param  object getbutton  from the reset button!
    * @param  string            no idea yet!
    */
    function loadConfig($widget=NULL,$what=NULL) {
        $this->NewConfig= array();
        if ($this->_configTabs) 
            foreach (array_keys($this->_configTabs) as $k) {
                $page = $this->notebook->page_num($this->_configTabs[$k]);
                $this->notebook->remove_page($page);
                $this->_configTabs[$k]->destroy();
            }
        
        // delete any other pages;
        if ($widget = $this->notebook->get_nth_page(0)) {
            $this->notebook->remove_page(0);
            $widget->destroy();
        }
        $this->_configTabs = array();
        $cmd = PEAR_Command::factory('config-show',$this->ui->config);
        $cmd->ui = &$this->ui;
        $cmd->run('config-show' ,'', array());
        $this->save->set_sensitive(FALSE); 
        $this->reset->set_sensitive(FALSE);
    }
    
    /**
    * Build the widgets based on the return 'data' array from config-show
    *
    * @param array see config-show for more details.
    */
    function buildConfig(&$array) {
        if (!$array) return;
        foreach ($array as $group=>$items) 
            foreach ($items as $v) {
                $this->_buildConfigItem($v[1],$v[2]);
            }

    }
    /**
    * Build the widgets for a configuration item
    *
    * @param string  configuration 'key'
    * @param string  configuration 'value'
    */
    function _buildConfigItem($k,$v) {
        //echo "BUIDLING CONF ITME $k $v\n";
        $group = $this->ui->config->getGroup($k);
        $gtktable =  $this->_getConfigTab($group);
        $prompt = $this->ui->config->getPrompt($k);
        $gtklabel = &new GtkLabel();
        $gtklabel->set_text($prompt);
        $gtklabel->set_justify(GTK_JUSTIFY_LEFT);
        $gtklabel->set_alignment(0.0, 0.5);
        $gtklabel->show();
        $r = $gtktable->nrows;
        $gtktable->attach($gtklabel, 0, 1, $r, $r+1, GTK_FILL,GTK_FILL);
        if ($v == '<not set>') 
            $v = '';
        
        $type = $this->ui->config->getType($k);
        switch ($type) {
            case 'string':
            case 'password':
            //case 'int': // umask: should really be checkboxes..
                $gtkentry = &new GtkEntry();
                $gtkentry->set_text($v);
                
                $gtkentry->connect_object_after('enter_notify_event',
                    array(&$this,'_setConfigHelp'),$this->ui->config->getDocs($k));
                $gtkentry->connect_after('changed', array(&$this,'_textChanged'),$k,$v);
                if ($type == 'password')
                    $gtkentry->set_visibility(FALSE);
                $gtkentry->show();
                $gtktable->attach($gtkentry, 1, 2, $r, $r+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                break;
            case 'directory':    
                $gtkentry = &new GtkEntry();
                $gtkentry->set_text($v);
                $gtkentry->set_editable(FALSE);
                $gtkentry->connect_object_after('enter_notify_event',
                    array(&$this,'_setConfigHelp'),$this->ui->config->getDocs($k));
                // store in object data the configuration tag
                $gtkentry->set_data('key',$k);
                $gtkentry->show();
                $gtktable->attach($gtkentry, 1, 2, $r, $r+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                $gtkbutton = &new GtkButton('...');
                $gtkbutton->connect_object_after('clicked', array(&$this->ui->_dirselect,'onDirSelect'),$gtkentry,$k);
                $gtkbutton->show();
                $gtktable->attach($gtkbutton, 2, 3, $r, $r+1, GTK_SHRINK,GTK_SHRINK);
                break;
            case 'set':
                $options = $this->ui->config->getSetValues($k);
                $gtkmenu = &new GtkMenu();
                $items = array();
                $sel = 0;
                foreach($options as $i=>$option) {
                    $items[$i] = &new GtkMenuItem($option);
                    $items[$i]->connect_object_after('activate', array(&$this, '_optionSelect'),$k,$option, $v);
                    $gtkmenu->append($items[$i]);
                    if ($option == $v) 
                        $sel = $i;
                }
                $gtkmenu->set_active($sel);
                $gtkmenu->show_all();
                $gtkoptionmenu = &new GtkOptionMenu();
                $gtkoptionmenu->set_menu($gtkmenu);
                $gtkoptionmenu->connect_object_after('enter_notify_event',
                    array(&$this,'_setConfigHelp'),$this->ui->config->getDocs($k));
                
                $gtkoptionmenu->show();
                $gtktable->attach($gtkoptionmenu, 1, 2, $r, $r+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                break;
            // debug: shourd  really be 
            case 'integer': // debug : should really be a set?
                $gtkadj = &new GtkAdjustment((double) $v, 0.0, 3.0, 1.0, 1.0, 0.0);
                $gtkspinbutton = &new GtkSpinButton($gtkadj);
                $gtkspinbutton->show();
                $gtkspinbutton->connect_object_after('enter_notify_event',
                    array(&$this,'_setConfigHelp'),$this->ui->config->getDocs($k));
                $gtkspinbutton->connect_after('changed', array(&$this,'_SpinChanged'),$k,$v);
               
                $gtktable->attach($gtkspinbutton, 1, 2, $r, $r+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                break;
                
            case 'mask': // unix file mask -- a table with lots of checkboxes...
                 ;
                $gtklabel->set_alignment(0.0, 0.1);
                $masktable =  &new GtkTable();
                $masktable->set_row_spacings(0);
                $masktable->set_col_spacings(10);
                $masktable->set_border_width(0);
                $masktable->show();
                $rows = array('User','Group','Everybody');
                $cols = array('Read','Write','Execute');
                $mult = 64;
                foreach($rows as $i=>$string) {
                    
                    $label = &new GtkLabel($string);
                    $label->set_justify(GTK_JUSTIFY_LEFT);
                    $label->set_alignment(0.0, 0.5);
                    $label->show();
                    $masktable->attach($label, 0, 1, $i, $i+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                    $add =4;
                    foreach($cols as $j=>$string) {
                        
                        if ($i) $string = ''; // first row show text only!
                        $gtkcheckbutton = new GtkCheckButton($string);
                        if (($mult * $add) & $v) $gtkcheckbutton->set_active(TRUE);
                        $gtkcheckbutton->show();
                        $gtkcheckbutton->connect_object_after('enter_notify_event',
                            array(&$this,'_setConfigHelp'),$this->ui->config->getDocs($k));
                        $gtkcheckbutton->connect_after('toggled',array(&$this,'_maskToggled'),$k,$mult * $add,$v);
                        $masktable->attach($gtkcheckbutton , $j+1, $j+2, $i, $i+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                        $add = $add/2;
                    }
                    $mult = $mult/8;
                }
                
                
                $gtktable->attach($masktable, 1, 2, $r, $r+1, GTK_FILL|GTK_EXPAND,GTK_FILL);
                break;
            default:
                echo "$prompt : ". $this->ui->config->getType($k) . "\n";    
        }
        
    }
    
    /**
    * Show the help text for a widget
    *
    * @param  object gtkevent            name of group tab
    * @param  string                     help text
    */
    function _setConfigHelp($event,$string) {
        $this->help->set_text($string);
    }
    /**
    * The GtkTables relating to the groups
    *
    * @var array  associative array of groupname -> gtktable
    * @access private
    */
    var $_configTabs = array(); // associative array of configGroup -> GtkTable
    /**
    * Get (or Make) A 'Group' Config Tab on the config notebook
    *
    * @param  string            name of group tab
    * @param  string            no idea yet!
    * @return object GtkTable   table which config elements are added to.
    */
    function &_getConfigTab($group) {
        if (@$this->_configTabs[$group]) 
            return $this->_configTabs[$group];
        $this->_configTabs[$group] = &new GtkTable();
        $this->_configTabs[$group]->set_row_spacings(10);
        $this->_configTabs[$group]->set_col_spacings(10);
        $this->_configTabs[$group]->set_border_width(15);
        $this->_configTabs[$group]->show();
        $gtklabel = &new GtkLabel($group);

        $gtklabel->show();
        $this->notebook->append_page($this->_configTabs[$group],$gtklabel);
        return $this->_configTabs[$group];
    }
   
    
    
    function _textChanged($widget,$key,$original) {
        $this->NewConfig[$key]  = $widget->get_text();
        if ($this->NewConfig[$key]  == $original) 
            unset($this->NewConfig[$key] );
        
        $this->ActivateConfigSave();
        
    }
    
     function _optionSelect($key,$value,$original) {
        $this->NewConfig[$key]  = $value;
        if ($this->NewConfig[$key]  == $original) 
            unset($this->NewConfig[$key] );
        
        $this->ActivateConfigSave();
        
    }
    function _spinChanged($widget,$key,$original) {
        $this->NewConfig[$key]  = $widget->get_value_as_int();
        if ($this->NewConfig[$key]  == $original) 
            unset($this->NewConfig[$key] );
        
        $this->ActivateConfigSave();
        
    }
    function _maskToggled($widget,$key,$value,$original) {
        if (!@$this->NewConfig[$key]) $this->NewConfig[$key] = $original;
        // set:
        if ($widget->get_active()) {
            if (!($value & $this->NewConfig[$key])) $this->NewConfig[$key] += $value;
        } else { // unset
            if ($value & $this->NewConfig[$key]) $this->NewConfig[$key] -= $value;
        }
        if ($this->NewConfig[$key]  == $original) 
            unset($this->NewConfig[$key] );
        $this->ActivateConfigSave();
    }    
    
    
    
    /**
    * Make the Save and reset buttons pressable.
    *
    */
    function ActivateConfigSave() {
        $set = TRUE;
        if (!$this->NewConfig) $set = FALSE;
        $this->save->set_sensitive($set); 
        $this->reset->set_sensitive($set);
    }
    
    function saveConfig() {
        
        //mmh now what :)
        $cmd = PEAR_Command::factory('config-set',$this->ui->config);
        foreach ($this->NewConfig as $k=>$v) 
            $cmd->doConfigSet('config-set' ,'', array($k,$v));
        $this->loadConfig();
    
    }
    
}
?>
