<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Link.php
*
* ARK View Link
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
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/View/Link.php
* @since      2.0
*
*/

namespace ARK\View;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Link extends Element
{
    private $_linkType = '';
    private $_name = '';
    private $_markup = '';
    private $_linkTitle = '';
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
    function __construct(Database $db, $link = NULL)
    {
        if ($link == NULL) {
            return;
        }
        try {
            parent::__construct($db, $link, 'link');
            $config = $db->getLink($link);
            $this->_linkType = $config['type'];
            $this->_name = $config['name'];
            $this->_markup = $config['markup'];
            $this->_linkTitle = $config['title'];
            $this->_linkClass = $config['link_class'];
            $this->_imageClass = $config['img_class'];
            $this->_listClass = $config['list_class'];
            $this->_lightbox = $config['lightbox'];
            $this->_image = $config['image'];
            $this->_page = $config['page'];
            $this->_reloadPage = $config['reload_page'];
            $this->_query = unserialize($config['query']);
            $this->_link = $config['url'];
            $this->_valid = true;
        } catch (DBALException $e) {
            return;
        }
    }
    // }}}
    // {{{ linkType()
    function linkType()
    {
        return $this->_linkType;
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
    // {{{ linkTitle()
    function linkTitle()
    {
        return $this->_linkTitle;
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
    // {{{ url()
    function url()
    {
        return $this->_url;
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
            $href = $this->_url;
        }
        return $href;
    }
    // }}}
    // {{{ buildForm()
    function buildForm(FormBuilder &$formBuilder)
    {
        if (!$this->isValid()) {
            return;
        }
        $formBuilder->add($this->_id, UriType::class, array('label' => $this->_title));
    }
    // }}}
    // {{{ fetchLinks()
    static function fetchLinks(Database $db, $element, $enabled = true)
    {
        $children = $db->getGroup($element, 'link', $enabled);
        $links = array();
        foreach ($children as $child) {
            $link = new Link($child['child']);
            if ($link->isValid()) {
                $links[] = $link;
            }
        }
        return $links;
    }
    // }}}
}
