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

  $Id: Info.php,v 1.5 2005/03/14 07:20:37 alan_k Exp $
*/

/**
 * Gtk Frontend - Pop up messages at present
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */


class PEAR_Frontend_Gtk_Info {
    var $ui; // main interface
    /**
    * holder for the icon 
    *
    * @var object GtkVbox
    */
    var $iconholder;
    /**
    * The text of the message
    *
    * @var object GtkLabel
    */
    var $label;
   /**
    * The Top pulldown 
    *
    * @var object GtkOptionMenu
    */
    var $window;
    
    
    var $_message = ""; // the current message
    
    /**
    * Constructor
    *
    * @param object PEAR_Frontend_Gtk 
    */
    
    function PEAR_Frontend_Gtk_Info(&$ui) {
        $this->ui = &$ui;
    }
    
    
    function show($message) {
        $this->_message .= $message . "\n";
        $this->window->set_title("MESSAGE");
        $this->label->insert(NULL, NULL, NULL, $this->_message);
        $this->label->set_line_wrap(false);
        $this->window->show();
        $this->isShow = TRUE; 
        while(gtk::events_pending()) gtk::main_iteration();

    }
    
    function close() {
        $this->label->delete_text(0,-1);
        $this->window->hide();
        $this->_message = "";
        return TRUE;
    }
}
?>