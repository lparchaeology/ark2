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

  $Id: Packages.php,v 1.16 2005/02/01 15:26:01 cellog Exp $
*/
require('PEAR/Frontend/Gtk/PackageData.php');
/**
 * Gtk Frontend - Section that deals with package lists
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */


class PEAR_Frontend_Gtk_Packages {

    var $ui; // main interface
    var $widget; // the list widget
    var $config; // reference to config;
    
    
    function PEAR_Frontend_Gtk_Packages(&$ui) {
        $this->ui = &$ui;
        $this->_loadLocalPackages();
        $this->_loadRemotePackages();
        $this->_mergePackages();
    }
    
              
    
     
    
    /*
    * call back when a row is pressed - hide/show the details and check it's isntalled status
    *  
    */
    function callbackSelectRow($widget,$node,$col) {
        //echo "GOT CALLBACK?";
        $package = $this->widget->node_get_row_data($node);
        if (!$package) return;
        
        switch ($col) {
         
            case 1:
                $this->ui->_summary->hide();
                $this->packages[$package]->toggleRemove();
                break;
            case 0:
            case 2: // install/ toggled
                $this->ui->_summary->hide();
                $this->packages[$package]->toggleInstall();
                break;
            case 3: // info selected
                if (!$package)  {
                    $this->ui->_summary->hide();
                    return;
                } 
                 
                $this->ui->_summary->toggle($this->packages[$package]);
                break;
            case -1: // startup!
                return;
            default:
                $this->ui->_summary->hide();
                break;
        }
        $packages = $this->getQueue();
         $this->ui->_widget_packages_install->set_sensitive(0);
        if ($packages)  $this->ui->_widget_packages_install->set_sensitive(1);
        
    }
     
     
      /*
    * Menu Callback - expand all
    */
    function expandAll() {
        $this->widget->expand_recursive();
    }
    /*
    * Menu Callback - colllapse all
    */
    function collapseAll() {
        $this->widget->collapse_recursive();
    }
    
    var $_remotePackageCache;  // array of remote packages.
    var $_localPackageCache;   // array of local packages
    var $packages;              // associative array of packagename : package
    
    
    
    /*
    * Load the local packages into this->_localPackageCache
    *  
    */
    function _loadLocalPackages () {
        clearstatcache();
        $reg = &$this->ui->config->getRegistry();
        $installed = $reg->packageInfo();
        $this->_localPackageCache = array();
        foreach($installed as $packagear) {
            $package = PEAR_Frontend_Gtk_PackageData::staticNewFromArray($packagear);
            $this->_localPackageCache[] = $package;
        }
        
    }
    /*
    * Load the remote packages into this->_remotePackageCache
    *  
    */
    function _loadRemotePackages () {
        $r = new PEAR_Remote($this->ui->config);
        $options = false;
        if ($this->ui->config->get('preferred_state') == 'stable')
            $options = true;
        $remote = $r->call('package.listAll', $options, $options, true);
        if (PEAR::isError($remote)) {
            $this->ui->displayFatalError($remote);
            return;
        }
        foreach ($remote as  $name => $packagear) {
            $package = PEAR_Frontend_Gtk_PackageData::staticNewFromArray($packagear);
            $package->name = $name;
            $this->_remotePackageCache[] = $package;
        }
        
    }
    /*
    * Add local and remote together and store in this->packages
    * Not: remembers installation status.
    */
    function _mergePackages () { // builds a mreged package list
        // start with remote list.
        
        //if (!$this->packages)
        foreach ($this->_remotePackageCache as $package) 
            $this->packages[$package->name] = $package;
     
        // merge local.    
        foreach ($this->_localPackageCache as  $package) {
            if (@$this->packages[$package->name]) {
                $this->packages[$package->name]->merge($package);
            } else {
                $this->packages[$package->name] = $package;
            }
            $this->packages[$package->name]->isInstalled = TRUE;
        }
        //merge existing status stuff..
        /*if ($this->packages) 
            foreach ($this->packages as $name=>$package) {
                $this->packages[$name]->QueueInstall = $package->QueueInstall;
                $this->packages[$name]->QueueRemove = $package->QueueRemove;
            }
         */
        ksort($this->packages);
        
    }
    
    /*
    * Reset the Queues on all objects
    */
    function resetQueue() {
        foreach(array_keys($this->packages) as $packagename) {
            $this->packages[$packagename]->QueueInstall = FALSE;
            $this->packages[$packagename]->QueueRemove = FALSE;
        }
    }
    /*
    * Get the List of packages to install
    *
    *@return array  array of PackageData objects
    */
    function &getQueue() {
        $ret = array();
        foreach(array_keys($this->packages) as $packagename) {
            if ($this->packages[$packagename]->QueueInstall) 
                $ret[] = &$this->packages[$packagename];
        }
        foreach(array_keys($this->packages) as $packagename) {
            if ($this->packages[$packagename]->QueueRemove) 
                $ret[] = &$this->packages[$packagename];
        }
        return $ret;
    }
    /*
    * Get the Packages to Remove.
    *
    *@return array  array of PackageData objects
    */
    
    
    /*
    * Nodes in a CTreeNodes
    *
    * @var array of Category Nodes
    *
    */
    var $_categoryNodes = array();
    
    /*
    * Load the package list into the clist.
    *
    *@return array  array of PackageData objects
    */
    function loadPackageList() {
        $this->ui->_widget_packages_install->set_sensitive(0);
        $this->widget->set_row_height(18);
        $this->widget->set_expander_style(GTK_CTREE_EXPANDER_TRIANGLE);
        $this->widget->set_line_style( GTK_CTREE_LINES_NONE);
     
        for($i=0;$i<4;$i++)
            $this->widget->set_column_auto_resize($i,TRUE);
        
        //while(gtk::events_pending()) gtk::main_iteration();
        $this->widget->clear();
        $this->widget->freeze();
        $this->_categoryNodes = array();
        foreach (array_keys($this->packages) as $packagename) {
             
            $package = &$this->packages[$packagename];
            $parent = $this->_getCategoryNode($package);
            //echo serialize($parent);
            $package->ui = &$this->ui;
            $package->createNode($parent);
        }
        $this->widget->thaw();
      
    }
    /*
    * Load the package list into the clist.
    *
    *@return array  array of PackageData objects
    */
    function &_getCategoryNode(&$package) {
        $ret = NULL;
        
        // work out category if it does not exist!!!!
        $category = $package->name;
        $parts = explode('_',$package->name);
        if ($parts[0])
            $category = $parts[0];
        $categoryName = $category;
        if ($package->category)  
            $categoryName = $package->category;
        
        
        //echo "GOT: {$package->name}:$categoryName:$category:\n";
        
        
        if ($category == $package->name) 
            return $ret;
            
        if (@$this->_categoryNodes[$category]) 
            return $this->_categoryNodes[$category];
        
        if (@$this->packages[$category])
            return $this->packages[$category]->gtknode;
            
            
        $this->_categoryNodes[$category] = $this->widget->insert_node(
            NULL, NULL, //parent, sibling
            array($categoryName, '','',''),5, 
            $this->ui->_pixmaps['folder_closed.xpm'][0],
            $this->ui->_pixmaps['folder_closed.xpm'][1],  
            $this->ui->_pixmaps['folder_open.xpm'][0],
            $this->ui->_pixmaps['folder_open.xpm'][1],
            false,true
        ); 
               
        return $this->_categoryNodes[$category];
        
    }
    
    
}
?>