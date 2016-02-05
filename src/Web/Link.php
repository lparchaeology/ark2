<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/Web/Link.php
*
* ARK Navigation Link Configuration
* A class containing the configuration for an ARK Navigation Link
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category   base
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/src/Web/Link.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\Web;
use LPArchaeology\ARK;

class Link
{
    private $_id = '';
    private $_valid = false;
    private $_type = '';
    private $_name = '';
    private $_markup = '';
    private $_title = '';
    private $_linkClass = '';
    private $_imageClass = '';
    private $_listClass = '';
    private $_lightbox = false;
    private $_image = '';
    private $_page = '';
    private $_reloadPage = '';
    private $_query = array();
    private $_link = '';

    // {{{ __construct()
    function __construct($link_id = NULL)
    {
        if ($link_id == NULL) {
            return;
        }
        $this->_id = $link_id;
        global $ado;
        $config = $ado->linkConfig($link_id, __METHOD__);
        if (count($config)) {
            $this->_valid = true;
            $this->_type = $config['type'];
            $this->_name = $config['name'];
            $this->_markup = $config['markup'];
            $this->_title = $config['title'];
            $this->_linkClass = $config['link_class'];
            $this->_imageClass = $config['img_class'];
            $this->_listClass = $config['list_class'];
            $this->_lightbox = $config['lightbox'];
            $this->_image = $config['image'];
            $this->_page = $config['page'];
            $this->_reloadPage = $config['reload_page'];
            $this->_query = unserialize($config['query']);
            $this->_link = $config['link'];
        }
    }
    // }}}
    // {{{ id()
    function id()
    {
        return $this->_id;
    }
    // }}}
    // {{{ isValid()
    function isValid()
    {
        return $this->_valid;
    }
    // }}}
    // {{{ type()
    function type()
    {
        return $this->_type;
    }
    // }}}
    // {{{ name()
    function name()
    {
        return $this->_name;
    }
    // }}}
    // {{{ markup()
    function markup()
    {
        return $this->_markup;
    }
    // }}}
    // {{{ title()
    function title()
    {
        return $this->_title;
    }
    // }}}
    // {{{ linkClass()
    function linkClass()
    {
        return $this->_linkClass;
    }
    // }}}
    // {{{ imageClass()
    function imageClass()
    {
        return $this->_imageClass;
    }
    // }}}
    // {{{ listClass()
    function listClass()
    {
        return $this->_listClass;
    }
    // }}}
    // {{{ lightbox()
    function lightbox()
    {
        return $this->_lightbox;
    }
    // }}}
    // {{{ image()
    function image()
    {
        return $this->_image;
    }
    // }}}
    // {{{ page()
    function page()
    {
        return $this->_page;
    }
    // }}}
    // {{{ reloadPage()
    function reloadPage()
    {
        return $this->_reloadPage;
    }
    // }}}
    // {{{ query()
    function query()
    {
        return $this->_query;
    }
    // }}}
    // {{{ link()
    function link()
    {
        return $this->_link;
    }
    // }}}
    // {{{ href()
    function href()
    {
        if ($this->_page) {
            $href = $this->_page.'.php';
            if ($this->_query) {
                $href .= '?';
                $parms = array();
                foreach ($this->_query as $key => $value) {
                    if ($value) {
                        $parms[] = $key.'='.$value;
                    } else {
                        $parms[] = $key;
                    }
                }
                $href .= implode('&', $parms);
            }
        } else {
            $href = $this->$link;
        }
        return $href;
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['link_id'] = $this->id();
        $config['type'] = $this->type();
        $config['name'] = $this->name();
        $config['mkname'] = $this->markup();
        $config['title'] = $this->title();
        $config['css_class'] = $this->linkClass();
        $config['img_class'] = $this->imageClass();
        $config['list_class'] = $this->listClass();
        $config['lightbox'] = $this->lightbox();
        $config['img'] = $this->image();
        $config['reloadpage'] = $this->reloadPage();
        $config['href'] = $this->href();
        return $config;
    }
    // }}}
    // {{{ elementLinks()
    static function elementLinks($element_id, $enabled = TRUE)
    {
        global $ado;
        $children = $ado->elementGroup($element_id, 'link', $enabled, __METHOD__);
        $links = array();
        foreach ($children as $child) {
            $link = new Link($child['child_id']);
            if ($link->isValid()) {
                $links[] = $link;
            }
        }
        return $links;
    }
    // }}}
}

?>
