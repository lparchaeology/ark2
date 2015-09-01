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

  $Id: Install.php,v 1.11 2005/02/01 15:33:55 cellog Exp $
*/

/**
 * Gtk Frontend -This class deals with the installing of packages
 * 
 * #TODO : Add remove methods, move to new 'InstallQueue/RemoveQueue API'
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */


class PEAR_Frontend_Gtk_Install {
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
    
    function PEAR_Frontend_Gtk_Install(&$ui) {
     
        // connect buttons?
        $this->ui = &$ui;
        
        
    }
    
    /**
    * The ProgressBar for total files
    * @var object GtkProgressBar
    */
    var $totalProgressBar; 
    /**
    * The ProgressBar for single download
    * @var object GtkProgressBar
    */
    var $fileProgressBar; 
     /**
    * The Label for Downloading File XXX
    * @var object GtkLabel
    */
    var $fileDownloadLabel;
    /**
    * The Label for Total XXX/XXX
    * @var object GtkLabel
    */
    var $totalDownloadLabel;
    /**
    * The list of packages to be added/removed
    * @var object GtkList
    */
    var $downloadList;
    
    /* 
    * Start the download process (recievs a list of package 'associative arrays'
    * #TODO : recieve list of package objects to install/remove!
    *
    */
    function start() {
       
        $this->downloadList->set_column_auto_resize(0,TRUE);
        $this->downloadList->set_column_auto_resize(1,TRUE);
        $this->downloadList->set_column_auto_resize(2,TRUE);
        $this->downloadList->set_column_auto_resize(3,TRUE);
        $this->downloadList->set_row_height(18);
        $this->ui->_widget_pages->set_page(1);
        $this->ui->_widget_done_button->set_sensitive(0);
        // load up the list into the download list..
        $this->downloadList->clear();
        $i=0;
        
        $queue = $this->ui->_packages->getQueue();
        foreach ($queue as $package) {
            
            $this->downloadList->append(array('','',$package->name,$package->summary));
            if ($package->QueueInstall) {
                $this->downloadList->set_pixmap($i,0,
                    $this->ui->_pixmaps['package.xpm'][0],
                    $this->ui->_pixmaps['package.xpm'][1]
                );
            } else {
                $this->downloadList->set_pixmap($i,0,
                    $this->ui->_pixmaps['stock_delete-16.xpm'][0],
                    $this->ui->_pixmaps['stock_delete-16.xpm'][1]
                );
            }
            $lines[$package->name] = $i;
            $i++;
            
        }
         
        
        
        $this->totalProgressBar->set_percentage(0);
        $this->fileProgressBar->set_percentage(0);
        $this->totalProgressBar->set_percentage(0);
        while(gtk::events_pending()) gtk::main_iteration();

            $j=0;
        $this->totalDownloadLabel->set_text("Total 0/{$i}");
            
         
            foreach ($queue as $package) {
                $this->fileDownloadLabel->set_text("Downloading {$package->name}");
                while(gtk::events_pending()) gtk::main_iteration();
                $package->doQueue();
                 
                $this->downloadList->set_pixmap($j,1,
                    $this->ui->_pixmaps['check_yes.xpm'][0],
                    $this->ui->_pixmaps['check_yes.xpm'][1]
                ); 
                $j++;
                $this->totalProgressBar->set_percentage((float) ($j/$i));
                $this->totalDownloadLabel->set_text("Total {$j}/{$i}");
                while(gtk::events_pending()) gtk::main_iteration();
               
                
            }    
        
        
        $this->totalProgressBar->set_percentage(1.0);
        $this->ui->_packages->_loadLocalPackages();
        $this->ui->_packages->_mergePackages();
        $this->ui->_packages->loadPackageList();
        
        $this->ui->_widget_done_button->set_sensitive(1);
        
    }
    /* 
    * GUI Callback - user presses the 'done button' 
    */
    function callbackDone() {
        $this->ui->_widget_pages->set_page(0);
    }
    /**
    * size of current file being downloaded
    * @var int
    * @access private
    */
    var $_activeDownloadSize =0;
    
    
    /*
    * PEAR_Command Callback (relayed) - used by downloader
    * @param string message type
    * @param string message data
    */
    
    function _downloadCallback($msg,  $params) {
        
        switch ($msg) {
            case 'setup':
            case 'done':    
            case 'saveas':
                while(gtk::events_pending()) gtk::main_iteration();
                return;
                
            case 'start':
                $this->_activeDownloadSize = $params[1];
                $this->fileProgressBar->set_percentage(0);
                while(gtk::events_pending()) gtk::main_iteration();
                return;
                
            case 'bytesread':
                $this->fileProgressBar->set_percentage(
                    (float) ($params / $this->_activeDownloadSize));
                while(gtk::events_pending()) gtk::main_iteration();
                return;
                
             ;
            default: // debug - what calls this?
                if (is_object($params)) $params="OBJECT";
                echo "MSG: $msg ". serialize($params) . "\n";
        }
    }
    
    function uninstallOutputData($msg) {
        return;
    }
    

}


?>