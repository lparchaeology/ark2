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

  $Id: DirSelect.php,v 1.5 2003/01/04 11:55:55 mj Exp $
*/

/**
 * Gtk Frontend - Configuration
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */


class PEAR_Frontend_Gtk_DirSelect {
    var $ui; // main interface
    /**
    * The GtkEntry that shows the currently seelcted directory
    *
    * @var object GtkEntry
    */
    var $entry;
       /**
    * The GtkDialog of the window
    *
    * @var object GtkDialog
    */
    var $window;
   /**
    * The Top pulldown 
    *
    * @var object GtkOptionMenu
    */
    var $optionMenu;
    /**
    * The full list of directories
    *
    * @var object GtkClist
    */
    var $cList;
    /**
    * Constructor
    *
    * @param object PEAR_Frontend_Gtk 
    */
    
    function PEAR_Frontend_Gtk_DirSelect(&$ui) {
        $this->ui = &$ui;
    }
    
     /**
    * Currently active widget to save result into (eg. gtkentry)
    *
    * @var object gtkentry 
    * @access private
    */
    var $_DirSelectActiveWidget = NULL;
    /**
    * Currently active configuration key
    *
    * @var string 
    * @access private
    */
    var $_DirSelectActiveKey = NULL;
    /**
    * Display the Directory selection dialog
    *
    * Displays the directory dialog, fills in the data etc.
    * 
    * @param   object gtkentry   The text entry to fill in on closing
    *
    */
    function onDirSelect($widget,$key) {
        // set the title!!
        $this->_DirSelectActiveKey = $key;
        $this->_DirSelectActiveWidget = &$widget;
        $prompt = 'xxx';
        $prompt = $this->ui->config->getPrompt($widget->get_data('key'));
        $this->window->set_title($prompt);
        
        $curvalue = $widget->get_text();
        // load the pulldown
        $this->_DirSelectSetDir(dirname($curvalue), basename($curvalue));
        $this->entry->set_text($curvalue);
        $this->window->show();
    }
    
    /**
    * Associated array of Row -> directory name
    *
    * It could be possible to get the row string using gtk calls......
    *
    * @var array
    * @access private
    */
    var $_DirSelectRows = array();
    
    /**
    * Load the directories into the directory list/pulldown etc.
    *
    * Loads the information into the popup / list of directories
    * TODO: Windows A:D: etc. drive support  
    *
    * @param  string $directory name of directory to browse
    * @param  string $file      name of file to select in list.
    *
    */
    function _DirSelectSetDir($directory, $file='.') {
        $parts = explode(DIRECTORY_SEPARATOR, $directory);
        $disp = array();
        $i=0;
        $items = array();
        $gtkmenu = &new GtkMenu();
        foreach($parts as $dirpart) {
            $disp[] = $dirpart;
            $dir = implode(DIRECTORY_SEPARATOR,$disp);
            if (!$dir && DIRECTORY_SEPARATOR == '/') $dir = '/';
            if (!$dir) continue;
            $items[$i] = &new GtkMenuItem($dir);
            $items[$i]->connect_object_after('activate', array(&$this,'_DirSelectSetDir'),$dir);
            $gtkmenu->append($items[$i]);
            $i++;
        }    
        $gtkmenu->set_active($i-1);
        $gtkmenu->show_all();
        $this->optionMenu->set_menu($gtkmenu);
        $base = $directory;
        
        $this->cList->select_row(0,0);
        $this->cList->freeze();
        $this->cList->clear();
        
        clearstatcache();
        $dh = opendir($base);
        $dirs = array();
        while (($dir = readdir($dh)) !== FALSE) {
            if (!is_dir($base.DIRECTORY_SEPARATOR.$dir)) continue;
            $dirs[] = $dir;
        }
        sort($dirs);
        $this->_DirSelectRows = array();
        $sel =0;
        $i=0;
        foreach($dirs as $dir) {
            $this->cList->append(array($dir)); 
            $this->_DirSelectRows[] = realpath($base.DIRECTORY_SEPARATOR.$dir);
            if ($dir == $file)
                $sel = $i;
            $i++;
        }
        $this->cList->thaw();  
        if ($file != '.') {
            
            $this->cList->select_row($sel,0);
            $this->cList->moveto($i,0,0,0);
            $this->entry->set_text($directory);
        } else {
            
            $this->_DirListBlockSel = TRUE;
            $this->cList->select_row(0,0);
            $this->_DirListBlockSel = TRUE;
        }
        
       
    }
    /**
    * Flag to block reselecting of current row after update
    *
    * Introduced to attempt to fix problem that when you double click to open a 
    * Directory, after refresh, the clist recieves a select signal on the same rows
    * and hence attemps to select the wrong directory..
    *
    * @var boolean
    * @access private
    */
    var $_DirListBlockSel = FALSE;
    /**
    * Initial Select Row (not double click)
    *
    * Makes this selected item the 'active directory'
    *
    * @param  string $directory name of directory to browse
    * @param  string $row       selected line
    *
    */
    function onDirListSelectRow($widget,$row) {
        
        if ($this->_DirListBlockSel) { 
          
            $this->_DirListBlockSel = FALSE;
            $widget->select_row(0,0);
            return;
        }
        if ($row < 0) return;
        $this->entry->set_text(@$this->_DirSelectRows[$row]);
    }
    
    /**
    * Callback when the list of directories is clicked
    *
    * Used to find the double click to open it.
    *
    * @param   object gtkclist  
    * @param   object gdkevent   
    *
    */

    function onDirListClick($widget,$event) {
        if ($event->type != 5)  return;
        $this->_DirSelectSetDir($this->entry->get_text());
    }
    /**
    * Callback when the cancel/destroy window is pressed
    *
    * has to return TRUE (see the gtk tutorial on destroy events)
    *
    * 
    */
    function onCancel() {
        $this->window->hide();
        return TRUE;
    }
    /**
    * Callback when the OK btn is pressed
    *
    * hide window and update original widget.
    *
    */
    
    function onOk() { 
        if (!$this->_DirSelectActiveWidget) return;
        $new= $this->entry->get_text();
        $old= $this->_DirSelectActiveWidget->get_text();
        
        if ($new != $old) {
            $this->_DirSelectActiveWidget->set_text($new);
            $this->ui->_config->NewConfig[$this->_DirSelectActiveKey] = $new;
            $this->ui->_config->ActivateConfigSave();
        }
        
        $this->_DirSelectActiveWidget = NULL;
        $this->window->hide();
    }
}
?>
