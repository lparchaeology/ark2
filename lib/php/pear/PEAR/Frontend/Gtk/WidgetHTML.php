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

  $Id: WidgetHTML.php,v 1.21 2003/01/04 11:55:55 mj Exp $
*/

/**
 * WidgetHTML - the HTML rendering widget
 *
 * Displays HTML/web pages
 *
 * @author Alan Knowles <alan@akbkhome.com>
 */

/*

Notes about this:

1. why is this all in one big class?
 - well, this is the second effort at making a web browser in pure php,
 the first effort was multiclassed, however it proved impossible to solve
 all the fundimental issues while messing around with all those files/references
 etc.

 As this class grows (and all those issues are worked out) it probably will
 be broken apart

2. How does it work.
Rendering:
 - First Load the data $this->loadURL($url); , stores it in $_source
 - Second tokenize the html
    tags become an array($tag, $attributes_string)
    raw text is just  a string in the token array. - similar to the php tokenizer.
    # TODO - this is a down and dirty tokenizer - either write it in C or break it into
    it's own class. - which does arrays of attributes as well..

 - Read the HTML and generate 3 key bits of data...
    $this->table = tables and td tags, the body is one big table (table[0])
    $this->_lines[], an array of line data (each bit of text is assigned a line, lines
        contain information like height and default left/right
    $this->_textParts[] an associative array of details about a particular item of text
         to be drawn after processing. - like font,color names etc.
    current state is stored in the stack / simple push/pop array for each item, and certain
        attributes, $this->in returns the attributes, $this->inID returns the token pos.


 - Recalculate the heights (post process)
   - goest through the table/lines and recaculates each lines real y location.
   - recalcs td heights etc.

 - Render objects - tables, td's then textparts..

User Interaction:
  - links are done with mouse motion detection and the $_links array.
  - page resize is based around the expose event, and testing the layout allocation.
    It does a delayed 1/2 second check to see if you are still resizing..
  - cursor changes: timer etc. in $this->_cursors[]


Well, if in doubt email me and I'll add more notes...


---------------------- USAGE EXAMPLE ------------------------------

include('PEAR/Frontend/Gtk/WidgetHTML.php');
dl('php_gtk.dll');
error_reporting(E_ALL);

$window = &new GtkWindow();
$window->set_name('Test Input');
$window->set_position(GTK_WIN_POS_CENTER);
$window->set_usize(600,400);
$window->connect_object('destroy', array('gtk', 'main_quit'));
$vbox = &new GtkVBox();
$window->add($vbox);
$vbox->show();

$t = new PEAR_Frontend_Gtk_WidgetHTML;
 //$t->test(dirname(__FILE__).'/tests/test3.html');

$t->loadURL("http://www.php.net");
$t->tokenize();
$t->Interface();
$vbox->pack_start($t->widget);

$button = &new GtkButton('Quit');
$vbox->pack_start($button, false, false);
$button->connect_object('clicked', array($window, 'destroy'));
$button->show();

$window->show();

gtk::main();











*/



class PEAR_Frontend_Gtk_WidgetHTML {
    var $widget; // what you add to your interface (as it's too complex to extend Scrolled window)
    var $_pixmap_area_x =1024;
    var $_pixmap_area_y = 5000;
    var $_source; // raw HTML
    var $_URL; // the URL
    function loadURL($URL) { // load a file into source - for testing only
        //echo "OPENING URL $URL\n";
        $this->_URL = trim($URL);
        $this->_URLparse = parse_url(trim($URL));
        $this->_source = @str_replace("\r", " ",implode('',file(trim($URL))));
        if ($this->_source) return TRUE;
        //$fh = fopen('/tmp/test','w'); fwrite($fh,$this->_source ); fclose($fh);
    }
    function loadTEXT($text) {
        $this->_source = $text;
    }
    
    var $_tokens = array(); // HTML Tokens id => array($tag,$attribute_string) | $string
    function tokenize() { // tokenize the HTML into $this->tokens
        //echo "TOKENIZING\n";
        $tok = strtok($this->_source,'<');
        $a[0] = $tok;
        while( $tok !== FALSE ) {
            $tok = strtok('<');
            $a[] = $tok;
        }
        $in_comment = '';
        $this->_tokens = array();
        foreach($a as $i=>$b) {
            if (trim($b) === '') continue;

            if ((substr($b,0,3) == '!--') && !preg_match('/-->/m',$b)) {
                $in_comment = $b;
                continue;
            }
            if ($in_comment)
                if (preg_match("/\-\-\>/m",$b)) {
                    $tmp = explode('-->',$b);
                    $this->_tokens[] = array('<!--',$in_comment.$tmp[0]);
                    $this->_tokens[] = $tmp[1];
                    $in_comment = '';
                    continue;
                } else {
                    $in_comment .= $b;
                    continue;
                }

            $l = strlen($b)-1;
            if ($b{$l} == '>') {
                if (($s = strcspn($b," \n")) == strlen($b)) {
                    $this->_tokens[] = array(strtoupper(substr($b,0,-1)));
                    continue;
                }
                $tag = strtoupper(substr($b,0,strcspn($b," \n")));
                $attribs = substr($b,strcspn($b," \n"),-1);
                $this->_tokens[] = array($tag,trim($attribs));
                continue;
            }
            if (strcspn($b," \n") == $l+1) {
                $this->_tokens[] = array(strtoupper(substr($b,0,strpos($b,'>'))));
                $this->_tokens[] = substr($b,strpos($b,'>')+1) ;
                continue;
            }
            if (strcspn($b," \n") > strpos($b,'>')) {
                $tag = substr($b,0,strpos($b,'>'));
                $this->_tokens[] = array(strtoupper($tag));
                $this->_tokens[] = substr($b,strpos($b,'>')+1);
                continue;
            }
            $tag = strtoupper(substr($b,0,strcspn($b," \n")));
            $attribs = substr($b,strcspn($b," \n")+1,strpos($b,'>')-strlen($tag)-1);
            $this->_tokens[] = array($tag,$attribs);
            $this->_tokens[] = substr($b,strpos($b,'>')+1);
        }
        /*
        ob_start();
        print_r($this->_tokens);
        $test = ob_get_contents();
        ob_end_clean();
        $fh = fopen('/tmp/tokens', 'w'); fwrite($fh,$test); fclose($fh);
        */
        //exit;
    }
    var $Start = FALSE; // start rering (eg. ignore headers)
    var $_Building=FALSE;
    function build() { // read the tokens and build the line/table arrays - then display
		if($this->Building) return;
        if(!$this->Realized) return;
        if (!$this->_tokens) return;
         
		$this->_Building=TRUE;
          $this->Start = FALSE;
        // reset all major variables;
        $this->_line_y = array();
        $this->stack = array();
        $this->cur = array();
        $this->curid = array();
        $this->_links = array();
        $this->tables = array();
        $this->td = array();
        $this->_lines = array();
        $this->_line =0;
        $this->_textParts = array();

        // make a fake first line

        $this->_makeFont();
        $this->_lines[0]['top'] =0;
        $this->_lines[0]['ascent'] =0;
        $this->_lines[0]['descent'] =0;
        $this->_updateLine('','START');
        $this->_lines[$this->_line]['bottom'] =0;
        $this->_lines[0]['left'] = 0;
        $this->_lines[0]['right'] = $this->_area_x;
        $this->tables[0]['left'] = 0;
        $this->tables[0]['right'] = $this->_area_x;
        $this->tables[0]['top'] = 0;
        $this->tables[0]['line'] = 0;

        $this->tables[0]['table'][1][1]['span'] = 1;
        $this->tables[0]['table'][1][1]['rowspan'] = 1;
        $this->tables[0]['table'][1][1]['width'] = $this->_area_x;
        $this->td[0]['tag'] = 'BODY';
        $this->td[0]['row'] = 1;
        $this->td[0]['col'] = 1;
        $this->td[0]['colspan'] = 1;
        $this->td[0]['rowspan'] = 1;
        $this->td[0]['table'] = 0;
        $this->td[0]['colwidth'] = 1;
        $this->td[0]['left'] = 0;
        $this->td[0]['right'] = $this->_area_x;
        $this->td[0]['totalcols'] = 1;
        $this->td[0]['lines'] = array();
        $this->td[0]['line_items'] = array();

        $this->_makeColors('#000000','#FFFFFF');
        $this->td[0]['gc'] =   '#FFFFFF'; // background
        $this->td[0]['bggc'] =  '#000000';
        $this->tables[0]['gc'] =   '#FFFFFF'; // background
        $this->tables[0]['bggc'] =  '#000000';

        $this->td[0]['height'] = 0;
        $this->td[0]['top'] = 0;
        $this->td[0]['bottom'] = 0;
        $this->tables[0]['table'][1][1]['td'] = &$this->td[0];
        $this->tables[0]['cells'] = array(0);
        $this->_nextLine("BEGIN");
        $endpos = count($this->_tokens);
        for($pos = 0;$pos < $endpos;$pos++) {
            while(gtk::events_pending()) gtk::main_iteration();
            $item = $this->_tokens[$pos];
            if (is_Array($item)) {
                $method = "push";
                if (!$item[0]) continue;
                //echo $pos;
                //echo "\nIN:".serialize($item)."\n";
                //$this->outputTAG($item[0]);
                if ($item[0]{0} == '/') {
                    $method = "pop";
                    $item[0] = substr($item[0],1);
                    $item[1] = '/';
                }
                //if (!$draw)


                switch (trim($item[0])) {
                    case '!DOCTYPE':
                    case 'HTML':
                    case 'META':
                    case 'LINK':
                    case 'HEAD':
                    case 'SCRIPT':
                    case 'STYLE':
                    case 'TITLE':

                    case 'FORM':

                    case 'INPUT':
                    case 'OPTION':
                    case 'TBODY':

                    case 'IMG':

                    case '!--':
                        break;

                    case 'UL':
                    case 'DL':
                        if ($method ==  'push') {
                            $this->_nextLine('UL'); // clear old line...
                            $this->_TDaddLine('UL');
                            $this->_lines[$this->_line]['indent'] = 20;
                        } else {
                            $this->_nextLine('UL'); // clear old line...
                            $this->_TDaddLine('UL');
                            $this->_lines[$this->_line]['indent'] = 0;
                            $this->_nextLine('UL2'); // clear old line...
                            $this->_updateLine('','UL2');
                            $this->_TDaddLine('UL');
                            $this->_lines[$this->_line]['indent'] = 0;

                        }
                        break;



                    case 'TABLE':               // unhandled stauff
                        if ($method == 'push') { // start
                            // move us down abit and start a new row
                            $this->_nextLine('CLEARPRETABLE'); // clear old line...
                            $this->_TDaddLine('TABLE start'); // add it to the table?
                            $this->tables[$pos]['from last']   = serialize($this->_lines[$this->_line]);

                            $this->tables[$pos]['pos'] = $pos;
                            $this->tables[$pos]['left']  =  $this->_lines[$this->_line]['left'];
                            $this->tables[$pos]['right'] =  $this->_lines[$this->_line]['right'];
                            $this->tables[$pos]['startright'] =  $this->_lines[$this->_line]['right'];
                            $this->tables[$pos]['top']   = $this->_lines[$this->_line]['top'];
                            $this->_nextLine('TABLE'); // new line object that contains the table information.
                            $this->_TDaddLine('TABLE');
                            $this->_lines[$this->_line]['top'] = $this->tables[$pos]['top'];


                            $this->tables[$pos]['line'] = $this->_line;

                            $this->_lines[$this->_line]['table'] = $pos;
                            $this->_lines[$this->_line]['top'] = $this->tables[$pos]['top'];
                            /*
                            if ($id = $this->inID('TD')) {
                                $this->td[$id]['lines'][] = $this->_line;
                                $this->td[$id]['line_items'][$this->_line] = &$this->_lines[$this->_line];
                            }
                            */
                            //$this->_updateLine("TABLE:{$pos}");// new line that is going to be the content.



                            $this->_TABLEcalc($pos);

                            $this->push($item[0],$pos,@$item[1]);
                            //$this->output("TABLE:$pos");
                            $this->_makeColors();
                            $this->tables[$pos]['gc'] = $this->_gc;
                            $this->tables[$pos]['bggc'] =$this->_bggc;

                        } else {  //



                            $table = $this->pop('TABLE',$pos);


                            $this->_TABLErecalc($table,$pos);



                            // update the container line
                            $line = $this->tables[$table]['line'];
                            $this->_lines[$line]['top'] = $this->tables[$table]['top'];
                            $this->_lines[$line]['descent'] = $this->tables[$table]['height'];
                            $this->_lines[$line]['ascent'] = 0;
                            $this->_lines[$line]['height'] = $this->tables[$table]['height'];
                            $this->_lines[$line]['bottom'] = $this->tables[$table]['bottom'];

                            //$this->_updateLine();
                            $this->_nextLine('ENDTABLE - clear'); // start a new line
                            $this->_TDaddLine('TABLE END');



                            // move Y xursor.
                            $this->_lines[$this->_line]['top'] = $this->tables[$table]['bottom'];
                            // move X xursor.
                            $this->_lines[$this->_line]['left'] = $this->tables[$table]['left'];

                            $this->_lines[$this->_line]['right'] = $this->tables[$table]['startright'];


                            $this->_lines[$this->_line]['x'] = $this->tables[$table]['left'];


                        }
                        break;


                    //case 'TR':
                    case 'CAPTION':
                    case 'TH':
                        $item[0] = 'TD';
                    case 'TD':

                        if ($method == 'push') { // start
                            if (!@$this->td[$pos]) {
                                $t = $this->inID('TABLE');
                                print_r($this->tables[$t]);
                                echo  "LOST TD?:$pos";
                                exit;
                            }
                            $this->td[$pos]['lines'] = array();
                            $this->td[$pos]['line_items'] = array();


                            $this->push($item[0],$pos,@$item[1]);

                            $this->_nextLine("TD - start");
                            $this->_TDaddLine("TD - start");

                            $this->_lines[$this->_line]['left'] = $this->td[$pos]['left'];
                            $this->_lines[$this->_line]['right'] = $this->td[$pos]['right'];
                            $this->_lines[$this->_line]['x'] = $this->td[$pos]['left'];

                            // this doesnt matter -   gets changed later...
                            //$this->_lines[$this->_line]['top'] = $this->td[$pos]['top'];

                            $this->_makeColors();

                            $this->td[$pos]['gc'] = $this->_gc;
                            $this->td[$pos]['bggc'] =$this->_bggc;

                        } else {
                            // if the td is before the table - dont over pop the stack
                            if ($this->inID('TD') < $this->inID('TABLE'))
                               break;
                            $this->_nextLine('TD - END');
                            $this->_TDaddLine('TD - END');
                            $td = $this->pop('TD',$pos);
                        }

                        break;


                    case 'BODY':
                        $this->Start = TRUE;
                        $this->$method($item[0],$pos);
                        if ($method == 'push') {
                            $backgroundcolor = $this->in('BGCOLOR');
                            if (!$backgroundcolor)
                                $backgroundcolor = "#000000";
                            $this->_makeColors('#000000',$backgroundcolor);
                            $this->td[0]['bggc'] =  $backgroundcolor;
                            $this->tables[0]['bggc'] =   $backgroundcolor;



                        }
                        break;
                    case 'PRE':
                        //$this->output($item[0]);
                        $this->linebr($this->_tokens[$pos][0],$pos);
                        $this->$method($item[0],$pos);
                        break;
                    case 'SELECT': // hide this stuff
                    case 'TEXTAREA':
                    case 'T':

                    case 'TT':
                    case 'CODE':
                    case 'B':
                    case 'I':
                        $this->$method($item[0],$pos);
                        break;

                    case 'SMALL':
                        $this->$method('H6',$pos,$item[0]{1});
                        break;
                    case 'H1':
                    case 'H2':
                    case 'H3':
                    case 'H4':
                    case 'H5':
                    case 'H6':
                        //$this->output($item[0]);
                        //if ($method == 'pop')
                            $this->linebr($this->_tokens[$pos][0],$pos);
                        $this->$method('H',$pos,$item[0]{1});
                        //if ($method == 'push')
                        //    $this->linebr($this->_tokens[$pos][0],$pos);
                        break;
                    case 'DIV': // ?? this stuf could contain formating?
                    case 'FONT':
                    case 'TR':
                        $this->$method($item[0],$pos,@$item[1]);
                        break;
                    case 'A':
                        if (@$item[1] && preg_match('/name=/i',@$item[1])) {
                            // add anchor
                        } else {
                            $ret = $this->$method($item[0],$pos,@$item[1]);
                        }


                        break;
                    case 'HR':
                        $this->linebr($this->_tokens[$pos][0],$pos);
                        $this->linebr($this->_tokens[$pos][0],$pos);
                        break;
                    case 'LI':
                    case 'DT':
                    case 'DD':
                        $this->$method($item[0],$pos,@$item[1]);
                        if ($method == 'push')
                            $this->linebr($this->_tokens[$pos][0],$pos);
                        break;

                    case 'BR':
                    case 'P':

                        //$this->output($item[0]);
                        //if ($method == 'push')
                        $this->linebr($this->_tokens[$pos][0],$pos);
                        break;
                    default:
                        echo "\nNOT HANDLED: -{$item[0]}-\n";
                        break;
                }

                continue;
            }
            //echo $pos;
            // strings only!
            if ($t = $this->inID('TABLE'))
                if ($t > ($td = $this->inID('TD'))) {
                    if (trim($item)) {
                        echo "TABLE : $t, TD: $td skipping $item\n";
                        exit;
                    }
                }
            $this->output($item,$pos);
        }
        $this->linebr('LAST LINE',$pos);


        $this->_TABLEmovelines(0);
        $this->_DrawingAreaRepaint();
        $this->_area_y = $this->_lines[$this->_line]['bottom'] ;
        $this->layout->set_size($this->_area_x , $this->_area_y );
        $this->drawing_area->size($this->_area_x,$this->_area_y);
        //$this->layout->thaw();
        //print_r($this->td);
        if (!@$this->pixmap || ($this->_area_x > $this->_pixmap_area_x) || ($this->_area_y > $this->_pixmap_area_y)) {
            if ($this->_area_x > $this->_pixmap_area_x) $this->_pixmap_area_x = $this->_area_x;
            if ($this->_area_y > $this->_pixmap_area_y) $this->_pixmap_area_y = $this->_area_y;
            if (@$this->pixmap) unset($this->pixmap);
            //echo "REMAKING PIXMAP: {$this->_pixmap_area_x},{$this->_pixmap_area_y}\n";
            $this->pixmap = new GdkPixmap($this->drawing_area->window,
                $this->_pixmap_area_x ,$this->_pixmap_area_y,
                -1);
        }
        $this->_DrawingAreaClear();
        foreach(array_keys($this->tables) as $pos)
            $this->_drawBlock($this->tables[$pos]);
        foreach(array_keys($this->td) as $pos)
            $this->_drawBlock($this->td[$pos]);
        foreach(array_keys($this->_textParts) as $id)
            $this->_drawPart($id);

        $this->_DrawingAreaRepaint();

        $vadj = $this->layout->get_vadjustment();
        $vadj->set_value(0);
        $vadj->changed();

		$this->_Building=FALSE;
        //print_r($this->tables);
        //print_r($this->_lines);

    }

    /*-----------------------------STACK STUFF--------------------------------*/

    var $check = ""; // put TABLE|TD to monitor the stack


    var $stack;// array of item stack
    var $cur; // top of stack
    var $curid; // id of top of stack
    function push($what,$pos,$attributes='') { // push a token or attributes onto the stack
        //echo "PUSH: $what, $attributes\n";
        if ($attributes && $attributes{strlen($attributes)-1} == '/') {
            //echo "SKIP";
            return;
        }
        if (!@$this->stack[$what])
            $this->stack[$what] = array();
        if (!$attributes) $attributes = ":";
        $this->stack[$what][] = array($pos,trim($attributes));
        $this->cur[$what] = trim($attributes);
        $this->curid[$what] = $pos;
        $this->_stackAttributes($attributes,$pos,'push');

        if ($this->check  && preg_match("/^(".$this->check.")$/",$what)) {
            echo "\nPUSH:$what:";print_r($this->stack[$what]);
            echo "\nCUR:{$this->cur[$what]}\n";
        }
    }
    function pop($what,$pos=0,$attributes=array()) { // pull a token or attributes off the stack
        if (!@$this->stack[$what]) return;
        list($id,$remove) = array_pop($this->stack[$what]);
        $this->cur[$what] = "";
        $this->curid[$what] = 0;
        if ($this->stack[$what])
            list($this->curid[$what],$this->cur[$what]) = $this->stack[$what][count($this->stack[$what])-1];
        $this->_stackAttributes($remove,$pos,'pop');
        /* debugging*/
        if ($this->check  && preg_match("/^(".$this->check.")$/",$what)) {
            echo "\nPOP:$what:AT$pos:";print_r($this->stack[$what]);
            echo "\nCUR:{$this->cur[$what]}\n";
        }
        return $id;
    }
    function clearStack($what,$pos) { // clear the stack 'what' of all items greater or equal than $pos
        //echo "CLEARING STACK OF $what for $pos\n ";
        if (!@$this->stack[$what]) return;
        $c = count(@$this->stack[$what]) -1;
        for($i=$c;$i>-1;$i--) {
            list($id,$attr) = $this->stack[$what][$i];
            if ($id >= $pos) $this->pop($what);
        }
    }
    function _stackAttributes($attributes,$pos,$method) { // add/remove from  stack attributes like color or font
        if ($attributes == ":") return;
        if ($attributes == '/') return;
        if ($attributes{0} == "#") return;

        $args = array();

        if (preg_match("/\scolor\=[\"\']?\#?([0-9A-F]{6})[\"\']?/mi",' '.$attributes,$args))
            $this->$method("FGCOLOR",$pos,"#".$args[1]);

        $args = array();
        if (preg_match("/\sbgcolor\=[\"\']?\#?([0-9A-F]{6})[\"\']?/mi",' '.$attributes,$args)) {
            $this->$method("BGCOLOR",$pos,"#".$args[1]);
        } else if (preg_match("/\sbgcolor\=[\"\']?([a-z]+)[\"\']?/mi",' '.$attributes,$args)) {
            $this->$method("BGCOLOR",$pos,strtolower($args[1]));
        }

        $args = array();
        if (preg_match("/\stext\=[\"\']?([a-z]+)[\"\']?/mi",' '.$attributes,$args))
            $this->$method("FGCOLOR",$pos,$args[1]);
        $args = array();
        if (preg_match("/\sclass\=[\"\']?([a-z]+)[\"\']?/mi",' '.$attributes,$args))
            $this->_stackStyle($method,$pos,$args[1]);

        $args = array();
        if (preg_match("/\shref\=[\"\']?([^\"\']+)[\"\']?/mi",' '.$attributes,$args)) {
            $col = $this->in('LINKCOLOR');
            if (!$col) $col = 'blue';
            $this->$method('FGCOLOR',$pos,$col);
            $this->$method('U',$pos,":");
            $this->$method('HREF',$pos,$args[1]. ' ');
            //echo "LINK: {$args[1]}\n";
        }
        $args = array();
        if (preg_match("/\slink\=[\"\']?\#?([0-9A-F]{6})[\"\']?/mi",' '.$attributes,$args))
              $this->$method('LINKCOLOR',$pos,"#".$args[1]);

        $args = array();
        if (preg_match("/\salign\=[\"\']?([a-z]+)[\"\']?/mi",' '.$attributes,$args))
            $this->$method("ALIGN",$pos,strtolower($args[1]));





    }
    function _stackStyle($method,$pos,$class) { //add/remove from stack class='xxx' (not implemented yet)
        return;
        /* TODO?? */
        switch ($class) {
            case 'programlisting':
                $this->$method("BGCOLOR",'');
        }

    }
    function in($what) {  // get the attributes for a tag from top of stack
        return @$this->cur[$what];
    }
    function inID($what) { // get the id for a tag from top of stack
        return @$this->curid[$what];
    }


    /*-----------------------------TEXT STUFF --------------------------------*/
    var $_links = array();
    var $_textParts = array(); // associative array of all the text parts to be drawn
    function linebr($item='',$reason) { // add a line break
        //
        if ($item == "/P") {
           // echo "LASTBR: {$this->lastbr} : CURRENT TEXTPARTS" . count($this->_textParts) . "\n";
            return;
        }
            //&& ($this->lastbr == ("P". count($this->_textParts)))) return;
        //if ($item && $this->lastbr && ($this->lastbr != $item)) return;
        //$this->widget->insert($this->_font,$this->_fgcolor,$this->bg_color,":$item:\n");
        //$this->outputTAG($item);
        $this->_makeFont();
        $this->_nextLine('LINEBREAK');
        $this->_updateLine('','LINEBR');
        $this->_TDaddLine("LINE BR $reason");
        $this->lastbr = count($this->_textParts);
    }
    function output($string,$pos) { // output a string

        if (!$this->Start) return;
        $string = $this->unhtmlentities($string);
        if (!$this->inID('PRE')) {
            $string = trim(preg_replace("/[\n \t\r]+/m", ' ',$string)) . ' ';
        } else {
            if (!trim($string)) return; // except PRE stuff!q
        }

        // invisible stuff
        if ($this->inID('SELECT')) return;
        if ($this->inID('TEXTAREA')) return;

        $this->_makeFont();
        $this->_makeColors();
        //echo $this->inID('PRE') ."output  {$string}\n";

        if ($this->inID('PRE')) {
            $this->outputPRE($string,$pos);
            return;
        }

        $this->outputTEXT($string,$pos);

    }
    function outputTAG($tag) {     // output a tag (for debugging)

        $this->_makeFont('-adobe-helvetica-bold-r-normal-*-*-80-*-*-p-*-iso8859-1');
        $this->_makeColors("#000000","#FFFF00",FALSE);
        $this->outputTEXT("<{$tag}>","tag");
    }
    function outputTEXT($string,$pos) { // really add to $this->_textParts a text item

        /*echo "outputTEXT ".

            "X:".$this->_lines[$this->_line]['x'] .
            "L:". $this->_lines[$this->_line]['left'].
            "R:". $this->_lines[$this->_line]['right'].
            "\n";
        */
        $array = $this->_breakString(
            $this->_lines[$this->_line]['x'],
            $this->_lines[$this->_line]['left'],
            $this->_lines[$this->_line]['right'],
            $string);
        // array of lines (startpos,len,text)
        //echo serialize($array);
        $c = count($array) -1;
        foreach($array as $i=>$data) {

            if ($data[2] !== '') {

                $this->_updateLine($data[2],'outputTEXT');

                $this->_textParts[] = array(
                    'string' => $data[2],
                    'line' =>   $this->_line,
                    'left' =>   $data[0],
                    'width' =>  $data[1],
                    'bggc' =>   $this->_bggc,
                    'gc'   =>   $this->_gc,
                    'font' =>   $this->_font,
                    'u'    =>   $this->inID('U'),
                    'href'    =>   $this->in('HREF')
                );
                //if ($this->inID('U')) echo "ADDING? " . $this->in('HREF') . "\n";
                $this->_lines[$this->_line]['textwidth'] = @$this->_lines[$this->_line]['textwidth'] + $data[1];
                $this->_lines[$this->_line]['align'] = $this->in('ALIGN');
                //$widget->show();
                $this->_updateLine("POS:$pos", 'outputTEXT2');
                $this->_lines[$this->_line]['x'] = $data[0] + $data[1];
                if ($c != $i) {
                    $this->_nextLine('TEXTout');
                    $this->_updateLine('','OutputTEXT NEWLINE');
                    $this->_TDaddLine('TEXT out');
                }
            }
        }

    }
    function outputPRE($string,$pos) { // output preformated text


        if (strpos($string,"\n") === FALSE) {

            $this->outputTEXT($string,$pos);
            return;
        }

        $array = explode("\n", $string) ;
        // array of lines (startpos,len,text)
        $c = count($array) -1;
        foreach($array as $i=>$line) {
            $this->_TDaddLine('PRE out');
            $this->_updateLine($line, 'outputPRE');
            //echo "OUTPUT PRE: $line\n";
            $this->outputTEXT($line,$pos);
            if ($c != $i) {
                $this->_nextLine('PREout');

            }
        }

    }
    function _drawPart($id) {  // draw a textPart on the pixmap
        $part = $this->_textParts[$id];
        $line = $this->_lines[$part['line']];
        //print_r($part);
        //print_r($line);
        //exit;
        while(gtk::events_pending()) gtk::main_iteration();
        if ($url = $part['href']) {
            $link = array(
                'left' => $part['left'] + $line['leftshift'],
                'right' => $part['left'] + $line['leftshift'] + $part['width'],
                'top' => $line['top'],
                'bottom' => $line['bottom'],
                'url' => $url
            );
            $this->_links[] = $link;
        }
        if (trim($part['string']))
            gdk::draw_rectangle($this->pixmap,
                $this->_gcs[$part['bggc']],true,
                $part['left'] + $line['leftshift'],  $line['top'],
                $part['width'], $line['height']
            );

        gdk::draw_text($this->pixmap,
            $this->_fonts[$part['font']], $this->_gcs[$part['gc']] ,
            $part['left'] + $line['leftshift'],  $line['y'],
            $part['string'], strlen($part['string'])
        );
        if ($part['u'])
            gdk::draw_rectangle($this->pixmap,
                $this->_gcs[$part['gc']],true,
                $part['left'] + $line['leftshift'],  $line['top'] + $line['height'] -1,
                $part['width'], 1
            );
        /*
        $this->drawing_area->draw(
            new GdkRectangle(
                $part['left'] + $line['leftshift'],  $line['bottom'],
                $part['width'], $line['height']
            )
        );
        */





    }
    function _drawBlock($ar) {  // draw a block (eg. TABLE or TD)
        if (!$ar['bggc']) {
            print_r($ar);
            echo 'NO BGGC';
            return;
        }
        while(gtk::events_pending()) gtk::main_iteration();
        gdk::draw_rectangle($this->pixmap,
            $this->_gcs[$ar['bggc']],true,
            $ar['left'], $ar['top'],
            $ar['right'], $ar['bottom'] -$ar['top']
        );
        /*
        $this->drawing_area->draw(
            new GdkRectangle(
                $ar['left'], $ar['top'],
                $ar['right'], $ar['bottom'] - $ar['top']));
            */
    }
    function _breakString($start,$left,$right,$string) { // break a string into lines and return an array

        $l = @$this->_fonts[$this->_font]->extents($string);
        //echo serialize($l);
        //echo "\nSTRINGLEN: $string =  {$l[2]} \n";
        if ($l[2] < ($right - $start)) {
            return array(array($start,$l[2],$string));
        }
        $ret = array();
        $buf = "";
        $words = explode(" ",$string);
        foreach ($words as $w) {

            $l = @$this->_fonts[$this->_font]->extents($buf . " " . $w);
            if ($l[2]< ($right - $start)) {
                $buf .= " " . $w;
                continue;
            }
            // its longer! and buffer is empty.. (and it's the first line!
            if ($buf == "" && ($start != $left)) {
                $ret[] = array($start,0,' ');
                $start = $left;
                if ($l[2] < ($right - $start)) {
                    $buf =  $w;
                    continue;
                }
                // it's longer and - just add it as a new line
                // even though it's too big!
                $ret[] = array($start,$l[2],$w);
                continue;
            }
            // its longer, add the buffer to stack, clear buffer
            $l = @$this->_fonts[$this->_font]->extents($buf);
            $ret[] = array($start, $l[2] ,$buf);
            $buf = $w;
            $start = $left;
        }
        if ($buf) {
            $l = @$this->_fonts[$this->_font]->extents($buf);
            $ret[] = array($start, $l[2] ,$buf);
        }
        return $ret;



    }
    function unhtmlentities ($string)  { // convert 'html entities' back into text
        $trans_tbl = get_html_translation_table (HTML_ENTITIES);
        $trans_tbl = array_flip ($trans_tbl);
        $ret = strtr ($string, $trans_tbl);
        return  preg_replace('/\&\#([0-9]{2,3})\;/me',"chr('\\1')",$ret);
    }

    /* -----------------------------LINE SUTFF -------------------*/

    var $_line; // current line
    var $_lines = array(); // array of all the lines in the document (used to work out 'y' locations
    function _updateLine($string = '',$updateReason) { // update line height based on current font
        // store the line height of the current line..

        //if (!@$this->_lines[$this->_line]['ascent']) $this->_lines[$this->_line]['ascent']=1;
        //if (!@$this->_lines[$this->_line]['decent']) $this->_lines[$this->_line]['decent']=5;

        if (@$this->_lines[$this->_line]['ascent'] < $this->_fonts[$this->_font]->c_ascent )
            $this->_lines[$this->_line]['ascent'] = $this->_fonts[$this->_font]->c_ascent;
        if (@$this->_lines[$this->_line]['descent'] < $this->_fonts[$this->_font]->c_descent )
            $this->_lines[$this->_line]['descent'] = $this->_fonts[$this->_font]->c_descent;
        if (!isset($this->_lines[$this->_line]['descent'])) {
            echo "FAILED TO FIND DESCENT {$this->_line}\n";
            echo serialize($this->_fonts[$this->_font]->descent);
            exit;
        }
        if (!@$this->_lines[$this->_line]['updateReason'])
            $this->_lines[$this->_line]['updateReason'] = '';
        $this->_lines[$this->_line]['updateReason'] .= $updateReason;

        $this->_lines[$this->_line]['height'] =
            $this->_lines[$this->_line]['descent'] + $this->_lines[$this->_line]['ascent'];

        $this->_calcLine($this->_line);

        // store the active block heights....



        if ($string)
            $this->_lines[$this->_line]['string'] .= $string;

    }
    function _calcLine($l) { // create line's y and bottom based on top + font stuff
        $this->_lines[$l]['y'] = $this->_lines[$l]['top'] + $this->_lines[$l]['ascent'];
        $this->_lines[$l]['bottom'] = $this->_lines[$l]['top'] + $this->_lines[$l]['height'];
        $this->_lines[$l]['leftshift'] = $this->_lines[$l]['indent'];
        if ($this->_lines[$l]['align'] == 'right')
            $this->_lines[$l]['leftshift'] = $this->_lines[$l]['right'] - $this->_lines[$l]['left'] - $this->_lines[$l]['textwidth'];
        if ($this->_lines[$l]['align'] == 'center')
            $this->_lines[$l]['leftshift'] = ($this->_lines[$l]['right'] - $this->_lines[$l]['left'] - $this->_lines[$l]['textwidth']) /2;



    }
    function _nextLine($reason) {  // create a new line (set up left/right,x top,y... etc.

        $this->_line++;
        if (!isset($this->_lines[$this->_line-1]['bottom'])) {
            print_r($this->_lines);
            echo "NO BOTTOM ON NEXT LINE";
            exit;
        }

        $this->_lines[$this->_line]['left']            =  $this->_lines[$this->_line-1]['left'];
        $this->_lines[$this->_line]['indent']          = @$this->_lines[$this->_line-1]['indent'];
        $this->_lines[$this->_line]['indentfromlast']  = @$this->_lines[$this->_line-1]['indent'];
        $this->_lines[$this->_line]['right_from_last'] =  $this->_lines[$this->_line-1]['right'];
        $this->_lines[$this->_line]['right']           =  $this->_lines[$this->_line-1]['right'];
        $this->_lines[$this->_line]['x']               =  $this->_lines[$this->_line]['left'];


        $this->_lines[$this->_line]['top'] = $this->_lines[$this->_line-1]['bottom'];
        $this->_lines[$this->_line]['y'] = $this->_lines[$this->_line-1]['bottom'];
        $this->_lines[$this->_line]['string'] = '';
        $this->_lines[$this->_line]['reason'] = $reason;
        $this->_lines[$this->_line]['ascent'] =0;
        $this->_lines[$this->_line]['descent'] =0;
        $this->_lines[$this->_line]['height'] =0;
        $this->_lines[$this->_line]['align'] ='left';
        //$this->_updateLine();
        $this->_calcLine($this->_line);

    }

    function _TDaddLine($reason = '') { // add a line to a block if it is inside one
        if ($id = $this->inID('TD')) {
            $table = $this->inID('TABLE');
            if ($table > $id) {
                echo "TRIED $reason TO ADD TD:$id to TABLE:$table\n";
                return;
            }
            if (!isset($this->td[$id]['lines'])) {
                print_r($this->td);
                echo "NO TD FOR $id\n";
                exit;
            }
            if (!in_array($this->_line,$this->td[$id]['lines'])) {
                $this->td[$id]['lines'][] = $this->_line;
                $this->td[$id]['line_items'][$this->_line] = &$this->_lines[$this->_line];
            }
        } else {
            if (!in_array($this->_line,$this->td[0]['lines'])) {
                $this->td[0]['lines'][] = $this->_line;
                $this->td[0]['line_items'][$this->_line] = &$this->_lines[$this->_line];
            }
        }
    }

    /*------------------------------FONTS AND COLORS --------------------------*/

    var $_fonts = array(); // associative array of fonts
    var $_font = NULL; // name (string) of current font
    function _makeFont($default='') { // make the font based on the stack information

        $font['pointsize'] = 100;
        $font['space'] = 'p';  // or 'm' for monospaced
        $font['family'] = 'times'; // or helvetica, courier
        $font['weight'] = 'medium'; // or bold
        $font['slant'] = 'r'; // or o

        /* not used? */
        $font['setwidth'] = 'normal';

        //PRE:
        if ($this->inID('PRE') || $this->inID('TT') || $this->inID('CODE') ) {
            //echo "IN PRE?" . $this->inID('PRE') . "\n";
            $font['family']  = 'courier';
            $font['space'] = 'm';
            $font['pointsize'] = 80;
        }
        if ($this->inID('B'))
            $font['weight']  = 'bold';
        if ($this->inID('I'))
            $font['slant']  = 'i';

        if ($v = $this->in('H')) {
            //&& is_int($v)
            // mapping 1=large = eg. 160 , 3=100 ok 5 = small
            // 20 * $v  would give 1=20, 2=40 .. 5=100
            // now 160-$v;; would give 1 = 140, 3=100
            $font['weight']  = 'bold';
            $font['pointsize'] = 180 - ($v * 20);
            //echo "setting point size = {$font['pointsize']}";
        }




        $fontname = $this->_getFontString($font);
        //echo $fontname;
        if ($default) $fontname =  $default;

        if (@!$this->_fonts[$fontname]) {
            $this->_fonts[$fontname] = gdk::font_load($fontname);
            //cached font size details
            $this->_fonts[$fontname]->c_ascent= $this->_fonts[$fontname]->ascent;
            $this->_fonts[$fontname]->c_descent= $this->_fonts[$fontname]->descent;
        }
        if (!$this->_fonts[$fontname])
            echo "FAIL: $fontname\n";
        //echo "SET FONT: $fontname\n";
        $this->_font =  $fontname;

    }
    function _getFontString($array) { // create a font string based on an associatve array describing the font
        $ret = "";
        foreach(array(
            'foundary','family','weight','slant','setwidth',
            'addedstyle', 'pixelsize','pointsize','resx','resy',
            'space','averagewidth','registry','encoding') as $i) {
            $a = '*';
            if (@$array[$i]) $a = $array[$i];
            $ret .= "-{$a}";
        }
        return $ret;
    }
    var $_gcs = array(); // associative array fo fgcolor:bgcolor to GC object
    var $_gc = NULL; // forground string eg. "#FFFFFF#000000" describing FG/BG color
    var $_bggc = NULL; //bacground string eg. "#FFFFFF#000000" describing FG/BG color
    var $_colors = array(); // associative array of colors id's to GtkColors

    function _makeColors($fgcolor = "#000000",$bgcolor = "#FFFFFF",$read=TRUE) {  // set the current colour based on stack, or overiden data
        if ($read) {
            if ($c = $this->in('FGCOLOR'))
                $fgcolor = $c;
            if ($c = $this->in('BGCOLOR'))
                $bgcolor = $c;
        }
        /* GC STUFF */

        if (!@$this->_gcs[$fgcolor] || !@$this->_gcs[$bgcolor]) {
            $window = $this->drawing_area->window;
            $cmap = $this->drawing_area->get_colormap();
        }

        if (!@$this->_gcs[$fgcolor]) {
            $this->_gcs[$fgcolor] = $window->new_gc();
            $this->_gcs[$fgcolor]->foreground =  $cmap->alloc($fgcolor);
        }
        if (!@$this->_gcs[$bgcolor]) {
            $this->_gcs[$bgcolor] = $window->new_gc();
            $this->_gcs[$bgcolor]->foreground =  $cmap->alloc($bgcolor);
        }
        $this->_gc = $fgcolor;
        $this->_bggc = $bgcolor;

    }

    /* ------------------------------ BASIC WIDGET STUFF ------------------*/
    //

    var $_area_x= 600; // default X width of Widget
    var $_area_y= 400; // default Y width of Widget
    var $layout; // GtkLayout

    var $drawing_area; // GtkDrawingArea
    var $scrolledwindow; // GtkScrolledwindow.

    function Interface() { // Create the Drawing Area

        $this->widget = &new GtkScrolledWindow();
        $hadj = $this->widget->get_hadjustment();
        $vadj = $this->widget->get_vadjustment();
        $hadj->connect('value-changed', array(&$this,'_LayoutScrolled'));
        $vadj->connect('value-changed', array(&$this,'_LayoutScrolled'));

        $this->layout =  &new GtkLayout($hadj,$vadj);
        $this->layout->set_size($this->_area_x,$this->_area_y);
        $this->layout->show();
        $this->widget->show();
        $this->widget->set_policy(GTK_POLICY_AUTOMATIC,GTK_POLICY_AUTOMATIC);
        $this->widget->add($this->layout);
        //$this->scrolledwindow->add_events(  GDK_EXPOSURE_MASK  );


        define('GDK_HAND2',60);
        define('GDK_ARROW',68);
        define('GDK_CLOCK',26);

        $this->_cursors[GDK_HAND2] = gdk::cursor_new(GDK_HAND2);
        $this->_cursors[GDK_ARROW] = gdk::cursor_new(GDK_ARROW);
        $this->_cursors[GDK_CLOCK] = gdk::cursor_new(GDK_CLOCK);

        $this->drawing_area  = &new GtkDrawingArea();
        $this->drawing_area->size($this->_area_x,$this->_area_y);
        $this->layout->put($this->drawing_area,0,0);
        //$this->drawing_area->set_events( GDK_ALL_EVENTS_MASK);
        $this->drawing_area->show();


        $this->drawing_area->connect("configure_event",        array(&$this,"_DrawingAreaCallbackConfigure"));
        $this->drawing_area->connect("expose_event",           array(&$this,"_DrawingAreaCallbackExpose"));
        $this->drawing_area->connect('motion_notify_event',array(&$this,"_DrawingAreaMotion"));
        $this->drawing_area->connect('button_press_event', array(&$this,"_DrawingAreaPress"));


        $this->drawing_area->set_events(
              GDK_EXPOSURE_MASK
			| GDK_LEAVE_NOTIFY_MASK
			| GDK_BUTTON_PRESS_MASK
			| GDK_POINTER_MOTION_MASK
			| GDK_POINTER_MOTION_HINT_MASK
        );
        //$this->drawing_area->set_events( GDK_ALL_EVENTS_MASK );
       // $this->layout->add_events(   GDK_KEY_PRESS_MASK   );

        $this->drawing_area->set_flags( GTK_CAN_FOCUS);
        

        //$this->drawing_area->connect("key_press_event",        array(&$this,"_DrawingAreaCallbackKeyPress"));
        //$this->drawing_area->connect("button_release_event",   array(&$this,"_DrawingAreaCallbackBtnPress"));
        //$this->drawing_area->connect("button_press_event",     array(&$this,"_DrawingAreacallbackBtnPress"));
        //$this->drawing_area->connect_after("event",    array(&$this,"_DrawingAreaMotion"));
        //$this->html->drawing_area->connect("expose_event",
        //    array(&$this,"callback_expose_event"));




    }
    var $_LayoutRefresh =0;
    function _LayoutScrolled() { // windows bug fixmo
    	//echo "SCROLL";
        $this->layout->queue_draw();
        $vadj= $this->widget->get_vadjustment();
        if (@!$this->drawing_area) return;
        if ($this->_LayoutRefesh==time()) return;
    	$this->_LayoutRefesh=time();
        $this->drawing_area->hide();
    	$this->drawing_area->show();


    }
    var $Realized = FALSE;
    var $pixmap; // the pixmap that everything gets drawn on
    function _DrawingAreaCallbackConfigure($widget, $event) { // the callback to create the pixmap & start building
        if (@$this->pixmap) return true;

        $this->Realized = TRUE;

        
        $this->build();
        $this->_setCursor(GDK_ARROW);

        return true;
    }


    function _DrawingAreaClear() { // draw a big rectangle over the drawing area..
        //return; // not needed
        gdk::draw_rectangle($this->pixmap,
            //$this->_gcs["#FFFFFF{$this->backgroundcolor}"],
            $this->drawing_area->style->white_gc,
            true, 0, 0,
            $this->_area_x,$this->_area_y);



        // draw somethin on it.
        //$this->drawing_area->realize();

    }
    function _DrawingAreaRepaint() {
        if (!$this->pixmap) return;
        gdk::draw_pixmap($this->drawing_area->window,
            $this->drawing_area->style->fg_gc[$this->drawing_area->state],
            $this->pixmap,
            0,0,0,0,$this->_area_x,$this->_area_y);
    }


    var $_new_area_x; // proposed new area!

    function _DrawingAreaCallbackExpose($widget,$event) { // standard callback to repaint a drawing area
        if (!$this->pixmap) return;

        if (!$this->_flag_rebuild  && ($this->layout->allocation->width > 400) && ($this->_area_x != $this->layout->allocation->width )) {

            if (  abs($this->_area_x - $this->layout->allocation->width) > 15) {
                $this->_new_area_x = $this->layout->allocation->width ;

                gtk::timeout_add(500, array(&$this,'_ChangeSize'), $this->layout->allocation->width);
            }

        }

        gdk::draw_pixmap($this->drawing_area->window,
            $widget->style->fg_gc[$widget->state],
            $this->pixmap,
            $event->area->x, $event->area->y,
            $event->area->x, $event->area->y,
            $event->area->width, $event->area->height);
        return false;
    }
    var $_flag_rebuild = FALSE;
    function _ChangeSize($newsize) {

        if (!$this->_flag_rebuild && ($newsize == $this->_new_area_x) && ($this->_area_x != $this->_new_area_x)) {
            //echo "BUILD? {$this->_area_x} = {$this->_new_area_x} \n";

            $this->_area_x = $this->_new_area_x;
            $this->_flag_rebuild = TRUE;
            $this->_setCursor(GDK_CLOCK);
            while(gtk::events_pending()) gtk::main_iteration();
            $this->build();
            $this->_setCursor(GDK_ARROW);
            while(gtk::events_pending()) gtk::main_iteration();
            $this->_flag_rebuild = FALSE;

        }
    }


    function _DrawingAreaMotion($widget,$event) {
        if ($event->is_hint) {
            $window = $event->window;
            $pointer = $window->get_pointer();
            $x = (int)$pointer[0];
            $y = (int)$pointer[1];
            $state = $pointer[2];
        } else {
            $x = (int)$event->x;
            $y = (int)$event->y;
            $state = $event->state;
        }
        $this->active_link  = $this->_getLink($x,$y);
        if ($this->active_link) {
            $this->_setCursor(GDK_HAND2);
        } else {
            $this->_setCursor(GDK_ARROW);
        }

        return true;

    }

    function _DrawingAreaPress() {
        if ($this->active_link) {
            if ($this->active_link{0} == "/") {
                $url = $this->_URLparse['scheme'] . "://".
                    $this->_URLparse['host'] .
                    $this->active_link;
            } else if (preg_match('/[a-z]+:/', $this->active_link)) {
                $url = $this->active_link;

            } else {
                $path = dirname($this->_URLparse['path']) . '/';
                if ($this->_URLparse['path']{strlen($this->_URLparse['path']) -1} == '/')
                    $path = $this->_URLparse['path'];
                $url = $this->_URLparse['scheme'] . "://".
                    $this->_URLparse['host'] .
                    $path.$this->active_link;
            }

            $this->_setCursor(GDK_CLOCK);
            while(gtk::events_pending()) gtk::main_iteration();
            $this->_DrawingAreaClear();
            $this->loadURL($url);
            $this->tokenize();
            $this->build();
            $this->_setCursor(GDK_ARROW);
        }
    }

    var $_cursor =0;
    function _setCursor($newcursor) {
        if ($this->_cursor == $newcursor) return;
        $w = $this->drawing_area->window;
        $w->set_cursor($this->_cursors[$newcursor]);
        $this->_cursor = $newcursor;
    }

    function _getLink($x,$y) {
        foreach($this->_links as $link) {
            if ($y < $link['top']) continue;
            if ($y > $link['bottom']) continue;
            if ($x < $link['left']) continue;
            if ($x > $link['right']) continue;
            return $link['url'];
        }
    }

    /* ------------------------------ TABLE STUFF  ------------------*/

    /*


    tables : complex stuff:
    got a table : look ahead to find
    tr = number of rows
    td = no of colums and how big they are...

    */


    function _findSubTables($pos) { // find subtables (used to skip them when calculating widths.
        $pos++;
        $table[] = array();
        $c = count($this->_tokens);
        while ($pos < $c) {
            if (!is_array($this->_tokens[$pos])) {
                $pos++;
                continue;
            }
            if ($this->_tokens[$pos][0] == "TABLE")
                $table[] = $pos;
            if ($this->_tokens[$pos][0] == "/TABLE") {
                array_pop($table);
                if (!$table) return $pos;
            }
            $pos++;
        }
        return $pos;
    }
    /* first version just divides available area! */
    var $td; // associative array of [posid]['width'|'start']
    function _TABLEcalc($pos) { // read a table and guess it's widths (left/right)
        $left = $this->tables[$pos]['left'];
        $right = $this->tables[$pos]['right'];
        $maxwidth = $right-$left;
        $tableid = $pos;
        if (preg_match("/\swidth\=[\"\']?([0-9]+)([%]?)[\"\']?/mi",' '.$this->_tokens[$pos][1],$args)) {
            if ($args[2]) {
                $right = $left + (int) (0.01 * $args[1]  * ($right - $left));
            } else {
                $right = $left + $args[1];
            }

        }


        $pos++;


        $table = array(); // table[row][col]
        $cells = array();
        $colsizes = array();
        $totalcols= 1;
        $totalrows = 1;
        $done = 0;
        $col =1;
        $row =0;
        $hasCaption = 0;
        $c = count($this->_tokens);
        while ($pos < $c) {
            if (!is_array($this->_tokens[$pos])) {
                $pos++;
                continue;
            }
            switch ($this->_tokens[$pos][0]) {


                case "TR":
                    $row++;
                    if ($col > $totalcols) $totalcols = $col-1;
                    if ($row > $totalrows) $totalrows = $row;
                    $col = 1;
                    break;

                case "CAPTION":
                    $hasCaption = $pos;
                    $table[$row][$col]['pos'] = $pos;
                    $table[$row][$col]['span'] = 1;
                    $table[$row][$col]['rowspan'] = 1;
                    $this->td[$pos]['pos'] = $pos;
                    $this->td[$pos]['row'] = $row;
                    $this->td[$pos]['col'] = $col;
                    $this->td[$pos]['colspan'] = 1;
                    $this->td[$pos]['rowspan'] = 1;
                    $this->td[$pos]['iscaption'] = 1;
                    $this->td[$pos]['table'] = $tableid;
                    $this->td[$pos]['tag'] =  $this->_tokens[$pos][0];
                    $cells[] = $pos;
                    $row++;
                    break;
                case "TD";
                case "TH";

                    while (@isset($table[$row][$col]['pos'])) // find next empty col.
                        $col++;
                    $args = array();
                    $span =1;
                    $rowspan =1;
                    $args = array();
                    if (!@$colsizes[$col]  && preg_match("/\swidth\=[\"\']?([0-9]+)([%]*)[\"\']?/mi",' '.@$this->_tokens[$pos][1],$args)) {
                        if ($args[2]) {
                            $colsizes[$col] = (int) (0.01 * $args[1]  * ($right - $left));
                        } else {
                            $colsizes[$col] = $args[1];
                        }
                    }


                    if (preg_match("/\scolspan\=[\"\']?([0-9]+)[\"\']?/mi",' '.@$this->_tokens[$pos][1],$args))
                        $span = $args[1];
                    if (preg_match("/\srowspan\=[\"\']?([0-9]+)[\"\']?/mi",' '.@$this->_tokens[$pos][1],$args))
                        $rowspan = $args[1];

                    $table[$row][$col]['pos'] = $pos;
                    $table[$row][$col]['span'] = $span;
                    $table[$row][$col]['rowspan'] = $rowspan;


                    for ($i=1;$i<$span;$i++)
                        $table[$row][$col+$i]['pos'] = $pos;
                    for ($i=1;$i<$rowspan;$i++)
                        for ($j=0;$j<$span;$j++)
                        $table[$row+$i][$col+$j]['pos'] = $pos;

                    $this->td[$pos]['tag'] =  $this->_tokens[$pos][0];
                    $this->td[$pos]['row'] = $row;
                    $this->td[$pos]['col'] = $col;
                    $this->td[$pos]['colspan'] = $span;
                    $this->td[$pos]['rowspan'] = $rowspan;
                    $this->td[$pos]['table'] = $tableid;
                    $this->td[$pos]['colwidth'] = 0;
                    $cells[] = $pos;

                    $col += $span;
                    break;
                case "/TR":
                    break;
                case "TABLE":
                    $spos = $pos;
                    $pos = $this->_findSubTables($pos); // skip sub tables
                    //echo "SKIPPED: $spos:$pos\n";
                    break;
                case "/TABLE":
                    $done = 1;
                    break;
            }
            //echo "$pos\n";
            if ($done) break;
            $pos++;
        }
        // I now have 2 arrays: $table[row][col][pos|span|rowspan] and $td[pos][col|row]
        // and totalcols;
        //print_r($table); exit;
        // do do a guess on the stuff...

        if ($col > $totalcols) $totalcols = $col-1;



        if (!$totalcols) return;


        if ($hasCaption) {
            $pos = $hasCaption;
            $row = $this->td[$pos]['row'];
            $col = $this->td[$pos]['col'];
            $table[$row][$col]['span'] = $totalcols;
            $this->td[$pos]['colspan'] = $totalcols;
            $this->td[$pos]['table'] = $tableid;
            for ($i=1;$i<$totalcols;$i++)
                $table[$row][$col+$i]['pos'] = $pos;
        }


        /* calculate the width */
        $colsizes = $this->_TABLEcalcWidth($colsizes, $maxwidth, $totalcols,$tableid);




        $x=$left;
        $row =0;
        for ($row =1; $row < ($totalrows + 1) ; $row++) {
            $cols = $table[$row];
            $x = $left;
            for ($col =1; $col < ($totalcols +1); $col++) {
                $data = $cols[$col];

                $td_id = $data['pos'];
                // if it's the first occurance set left and right
                if (($this->td[$td_id]['row'] == $row)
                    && ($this->td[$td_id]['col'] == $col)) {
                    $this->td[$td_id]['left'] = $x;
                    $this->td[$td_id]['right'] = $x;
                }

                if ($this->td[$td_id]['row'] == $row) {
                    $this->td[$td_id]['colwidth'] += $colsizes[$col];
                    $this->td[$td_id]['right']    += $colsizes[$col];
                }
                $table[$row][$col]['width'] =  $colsizes[$col];
                //echo "R{$row}:C:{$col}:{$this->td[$td_id]['left']},{$this->td[$td_id]['right']}\n";
                $x +=  $colsizes[$col];

                /// for reference only
                $this->td[$td_id]['totalcols'] = $totalcols;
            }

        }
        //if ($tableid ==142 )  {
        //     print_r($this->td);
        //       exit;
        //  }
        $this->tables[$tableid]['table'] =$table;
        $this->tables[$tableid]['cells'] =$cells;
        $this->tables[$tableid]['colsizes'] =$colsizes;
        $this->tables[$tableid]['left'] =$left;
        $this->tables[$tableid]['right'] =$left + $maxwidth;
        $this->tables[$tableid]['totalrows'] =$totalrows;
        $this->tables[$tableid]['totalcols'] =$totalcols;
        //print_r($this->tables); exit;


    }

    function _TABLEcalcWidth($cols,$width,$total,$tableid) { // calculate a tables column sizes

        $res = array();
        // add up the widths
        // and how many cells are used
        $sum =0;
        $empty =0;
        for ($i=1;$i<($total+1);$i++) {
            if (@$cols[$i]) {
                $sum += $cols[$i];
            } else {
                $empty++;
            }
        }
        $available = $width-$sum;
        $default =0;
        $factor = 1;

        if ($empty)  {
            $default = (int) ($available / $empty);
        } else {
            $factor = $width/$sum;
        }
        for ($i=1;$i<($total+1);$i++) {
            if (@$cols[$i]) {
                $res[$i] = (int) ($cols[$i] * $factor);
            } else {
                $res[$i] = (int) ($default * $factor);
            }
        }
        /*
        print_r(
            array(
                'tableid' => $tableid,
                'cols' =>$cols,
                'width' =>$width,
                'total' =>$total,
                'result' =>$res,
                'available' => $available,
                'empty' => $empty,
                'factor' => $factor,
                'sum' => $sum
                ));

        */
        return $res;
    }


    function _TABLErecalc($id,$end) { // recalculate a tables cell heights (called at </table>
        //$rowx[$row]['top'] =
        //$rowx[$row]['bottom'] =

        $table = $this->tables[$id]['table'];
        $top = $this->tables[$id]['top'];
        $totalrows = $this->tables[$id]['totalrows'];
        $totalcols = $this->tables[$id]['totalcols'];

        $this->tables[$id]['end'] = $end;
        //if ($id == 85) echo "$top"; exit;
        $rows[1]['top'] = $top;
        for ($row =1; $row < ( $totalrows + 1) ; $row++) {
            $cols = $table[$row];

            // row
            $height  = 0;
            for ($col =1; $col < ($totalcols + 1) ; $col++) {
                $data = $cols[$col];
                $td_id = $data['pos'];
                $this->_TDcalcHeight($td_id);

                // top - is it the first row
                if (@$table[$row-1][$col]['pos'] != $td_id)
                    $this->td[$td_id]['top'] = $top;


                // bottom = ?
                if (@$table[$row+1][$col]['pos'] != $data['pos'])
                    if ($height < @$this->td[$td_id]['height'])
                        $height = $this->td[$td_id]['height'];

                $bottom = $top + $height;
            }

            // set the bottom for all cols.
            for ($col =1; $col < ($totalcols+1); $col++) {
                $data = $cols[$col];
                $td_id = $data['pos'];

                if (@$table[$row+1][$col]['pos'] != $td_id)
                    $this->td[$td_id]['bottom']  = $bottom;

                $this->tables[$id]['table'][$row][$col]['td'] = &$this->td[$td_id];
            }

            //echo "ROW:$row:TOP:$top\n";
            $top = $bottom;

        }
        $this->tables[$id]['height'] = $bottom - $this->tables[$id]['top'];
        $this->tables[$id]['bottom'] = $bottom;
        $this->_TABLEmovelines($id);
        //print_r($this->tables); exit;
        //if ($end > 160) {
         //    print_r($this->tables);
        //    echo "$id::$end\n";
            //exit;
       // }
    }
    function _TDcalcHeight($id) { // calculate a TD's height based on the lines inside it.
        //if ($this->td[$id]['height']) return;
        $h=0;
        foreach ($this->td[$id]['lines'] as $lineid)
            $h += @$this->_lines[$lineid]['ascent'] + @$this->_lines[$lineid]['descent'];
        //if (!$h) $h=16;
        $this->td[$id]['height'] = $h;
    }
    function _TABLEmovelines($table) { // move all the lines in a TABLE & TD to correct locations (recursively)

        $cells = $this->tables[$table]['cells'];
        foreach($cells as $td) {
            $lines = $this->td[$td]['lines'];
            $top = $this->td[$td]['top'];
            foreach($lines as $line) {
                //echo "UpdateLine:$line\n";
                $this->_lines[$line]['top'] = $top;
                $this->_calcLine($line);

                if (@$subtable = $this->_lines[$line]['table']) {
                    $this->tables[$subtable ]['top'] = $top;
                    $this->_TABLErecalc($subtable, $this->tables[$subtable ]['end']);
                    $this->_calcLine($line);
                }
                if ($this->_lines[$line]['bottom'] < $this->_lines[$line]['top'] ) {
                    echo "BOTTOM LESS THAN TOP!\n";
                    print_r($lines);
                    exit;
                }
                $top = $this->_lines[$line]['bottom'];
            }
        }
        //$this->tables[$table]['bottom'] = $top;
        //$this->tables[$table]['height'] = $top - $this->tables[$table]['top'] ;
    }

}

 


?>