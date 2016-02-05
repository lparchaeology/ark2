<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkweb/page_config.php
*
* ArkWeb Page Configuration
* A class containing the configuration for an ArkWeb page
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
* @link       http://ark.lparchaeology.com/code/php/arkweb/page_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\Web;

class PageConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_name = '';
    private $_title = '';
    private $_file = '';
    private $_sgrp = '';
    private $_navOrder = 0;
    private $_navName = '';
    private $_navLinkVars = '';
    private $_codeDir = '';
    private $_visible = FALSE;
    private $_enabled = FALSE;
    private $_layouts = array();

    // {{{ __construct()
    function __construct()
    {
    }
    // }}}
    // {{{ _loadConfig()
    private function _loadConfig($pageId, $config)
    {
        if ($config) {
            $this->_id = $pageId;
            $this->_valid = TRUE;
            $this->_name = $config['name'];
            $this->_name = $config['title'];
            $this->_file = $config['file'];
            $this->_sgrp = $config['sgrp'];
            $this->_navOrder = $config['nav_seq'];
            $this->_navName = $config['navname'];
            $this->_navLinkVars = $config['nav_link_vars'];
            $this->_codeDir = $config['code_dir'];
            $this->_visible = $config['visible'];
            $this->_enabled = $config['enabled'];
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
    // {{{ name()
    function name()
    {
        return $this->_name;
    }
    // }}}
    // {{{ title()
    function title()
    {
        return $this->_title;
    }
    // }}}
    // {{{ file()
    function file()
    {
        return $this->_file;
    }
    // }}}
    // {{{ sgrp()
    function sgrp()
    {
        return $this->_sgrp;
    }
    // }}}
     // {{{ navOrder()
    function navOrder()
    {
        return $this->_navOrder;
    }
    // }}}
    // {{{ navName()
    function navName()
    {
        return $this->_navName;
    }
    // }}}
    // {{{ navLinkVars()
    function navLinkVars()
    {
        return $this->_navLinkVars;
    }
    // }}}
    // {{{ codeDir()
    function codeDir()
    {
        return $this->_codeDir;
    }
    // }}}
    // {{{ isVisible()
    function isVisible()
    {
        return $this->_visible;
    }
    // }}}
    // {{{ isEnabled()
    function isEnabled()
    {
        return $this->_enabled;
    }
    // }}}
    // {{{ layout()
    function layout($module_id, $layout_role)
    {
        if (!array_key_exists($module_id, $this->_layouts) or !array_key_exists($layout_role, $this->_layouts[$module_id])) {
            $this->_layouts[$module_id][$layout_role] = LayoutConfig::pageLayout($this->id(), $module_id, $layout_role);
        }
        return $this->_layouts[$module_id][$layout_role];
    }
    // }}}
    // {{{ page()
    static function page($pageId)
    {
        global $ado;
        $config = $ado->get("SELECT * FROM cor_conf_page WHERE page_id = ?", array($pageId), "PageConfig")[0];
        $page = new PageConfig();
        $page->_loadConfig($pageId, $config);
        return $page;
    }
    // }}}
    // {{{ pages()
    static function pages()
    {
        global $ado;
        $pages = array();
        $rows = $ado->get("SELECT * FROM cor_conf_page WHERE enabled = ?", array(1), "PageConfig");
        foreach ($rows as $config) {
            $page = new PageConfig();
            $page->_loadConfig($config['page_id'], $config);
            $pages[] = clone $page;
        }
        return $pages;
    }
    // }}}
}
?>
