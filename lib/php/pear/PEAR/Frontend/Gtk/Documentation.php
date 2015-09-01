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

  $Id: Documentation.php,v 1.3 2003/01/04 11:55:55 mj Exp $
*/

/**
 * Gtk Frontend Documentation -This class deals with the browsing and downloading? the documentation.
 * 
 * #TODO : ..
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */
require_once "PEAR/Frontend/Gtk/WidgetHTML.php";


class PEAR_Frontend_Gtk_Documentation {
    /**
    * The Main User interface object
    * @var object PEAR_Frontend_Gtk
    */
    var $ui; // main interface
    
    /*
    * Gtk Installer Constructor
    *
    * #TODO: most of this can be moved to the glade file!?
    * @param object PEAR_Frontend_Gtk
    */
    
    function PEAR_Frontend_Gtk_Documentation(&$ui) {
        $this->ui = &$ui;
        
    }
    
    /**
    * The HTML Browser component
    * @var object PEAR_Frontend_Gtk_WidgetHTML
    */
    var $_html; 
    
    /**
    * The Vbox holder for browser
    * @var object GtkVbox
    */
    var $holder; 
    
    function init() {
        $this->_html = &new PEAR_Frontend_Gtk_WidgetHTML;
        $this->_html->Interface(); 
        $this->holder->add($this->_html->widget);
        $this->_loadPackages();
    }
    /**
    * The List of packages on the documentaiton page
    * @var object GtkCombo
    */
    var $package_combo; 
    
    /**
    * The Currently Selected package (Text) to look at
    * @var object GtkCombo
    */
    var $package_comboentry; 
    
    function _loadPackages() {
        $packages = array_keys($this->ui->_packages->packages);
        $this->package_combo->set_popdown_strings($packages);
        $list = $this->package_combo->list;
        $list->connect_after('button-release-event',array(&$this,'_PackageSelected'));
    }
    /**
    * The Currently Selected package to look at
    * @var string 
    */
    var $_selectedPackage = "";
    
    function _PackageSelected() {
        $new = $this->package_comboentry->get_text();
        if ($new == $this->_selectedPackage) return;
        $this->_selectedPackage=$new;
        $this->_loadViews();
        $category = str_replace(' ','_',strtolower($this->ui->_packages->packages[$new]->category));
        $new = strtolower($new);
        $newurl = "http://pear.php.net/manual/en/html/packages.{$category}.{$new}.html";
        if ($this->showURL($newurl)) return;
        $parts = explode('_', $new);
        $newurl = "http://pear.php.net/manual/en/html/packages.{$parts[0]}.{$new}.html";
        if ($this->showURL($newurl)) return;
        $newurl = "http://pear.php.net/manual/en/html/core.{$new}.html";
        if ($this->showURL($newurl)) return;
        $newurl = "http://pear.php.net/manual/en/html/class.{$new}.html";
        if ($this->showURL($newurl)) return;
        
        $this->_html->loadTEXT("<BODY><H1>Sorry</H1>{$newurl} was not found</BODY>");
        $this->_html->tokenize();
        $this->_html->build();
        
    }
    
    function show() {
        $this->ui->_widget_pages->set_page(3);
        return $this->showURL('http://pear.php.net/manual/en/html/index.html');
    }
    
    
    function showURL($URL) {
        if (!$this->_html->loadURL($URL)) return;
        $this->_html->tokenize();
        $this->_html->build();
        return TRUE;
    }
    
    function _loadViews() {
        $views = array('PEAR Manual');
        $this->view_combo->set_popdown_strings($views);
    }
    

}


?>