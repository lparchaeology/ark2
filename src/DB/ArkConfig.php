<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/ark_config.php
*
* Ark Configuration
* A class containing the configuration for an Ark installation
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
* @link       http://ark.lparchaeology.com/code/php/arkdb/ark_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

include_once('config/server.php');
include_once('config/paths.php');

class ArkConfig
{
    private $_ado = FALSE;
    private $_valid = FALSE;
    private $_name = '';
    private $_markup = '';
    private $_defaultSiteCode = '';
    private $_defaultLanguage = 'en';
    private $_defaultSkin = 'arkologik';
    private $_logInserts = FALSE;
    private $_logUpdates = FALSE;
    private $_logDeletes = FALSE;
    private $_searchMode = 'live';
    private $_searchFreeTextMode = 'fancy';
    private $_thumbWidth = 240;
    private $_thumbHeight = 240;
    private $_webThumbWidth = 1000;
    private $_webThumbHeight = 1000;
    private $_maxUploadSize = '10M';
    private $_formMethod = 'post';
    private $_anonymousLogin = FALSE;
    private $_anonymousUser = 'anon';
    private $_anonymousPassword = 'anon';
    private $_displayErrors = FALSE;
    private $_codeVersion = '1.2.90';
    private $_originalVersion = '';
    private $_databaseVersion = '';
    private $_modules = FALSE;

    // {{{ __construct()
    function __construct()
    {
        global $sql_server, $sql_user, $sql_pwd, $ark_db;
        $this->_ado = new ADO($sql_server, $sql_user, $sql_pwd, $ark_db);
        // TODO ErrorcChecking
        $conf = $this->_ado->getRow('cor_conf_ark', array(), array(), __METHOD__);
        $this->_valid = TRUE;
        $this->_name = $conf['name'];
        $this->_markup = $conf['markup'];
        $this->_defaultSiteCode = $conf['site_code'];
        $this->_defaultLanguage = $conf['language'];
        $this->_defaultSkin = $conf['skin'];
        $this->_logInserts = $conf['log_ins'];
        $this->_logUpdates = $conf['log_upd'];
        $this->_logDeletes = $conf['log_del'];
        $this->_searchMode = $conf['search_mode'];
        $this->_searchFreeTextMode = $conf['search_ftx_mode'];
        $this->_thumbWidth = $conf['arkthumb_width'];
        $this->_thumbHeight = $conf['arkthumb_height'];
        $this->_webThumbWidth = $conf['webthumb_width'];
        $this->_webThumbHeight = $conf['webthumb_height'];
        $this->_maxUploadSize = $conf['max_upload_size'];
        $this->_formMethod = $conf['form_method'];
        $this->_anonymousLogin = $conf['anon_login'];
        $this->_anonymousUser = $conf['anon_user'];
        $this->_anonymousPassword = $conf['anon_password'];
        $this->_displayErrors = $conf['display_errors'];
        $this->_originalVersion = $conf['version_original'];
        $this->_databaseVersion = $conf['version_database'];
        $this->_modules = ModuleConfig::modules();
    }
    // }}}
    // {{{ pageId()
    function isValid()
    {
        return $this->_valid;
    }
    // }}}
    // {{{ db()
    function db()
    {
        return $this->_ado;
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
    // {{{ defaultSiteCode()
    function defaultSiteCode()
    {
        return $this->_defaultSiteCode;
    }
    // }}}
    // {{{ defaultLanguage()
    function defaultLanguage()
    {
        return $this->_defaultLanguage;
    }
    // }}}
    // {{{ defaultSkin()
    function defaultSkin()
    {
        return $this->_defaultSkin;
    }
    // }}}
    // {{{ defaultSkinDir()
    function defaultSkinDir()
    {
        return $this->skinsDir().DIRECTORY_SEPARATOR.$this->defaultSkin();
    }
    // }}}
    // {{{ defaultSkinDir()
    function defaultSkinPath()
    {
        return $this->skinsPath().'/'.$this->defaultSkin();
    }
    // }}}
    // {{{ logInserts()
    function logInserts()
    {
        return $this->_logInserts;
    }
    // }}}
    // {{{ logUpdates()
    function logUpdates()
    {
        return $this->_logUpdates;
    }
    // }}}
    // {{{ logDeletes()
    function logDeletes()
    {
        return $this->_logDeletes;
    }
    // }}}
    // {{{ searchMode()
    function searchMode()
    {
        return $this->_searchMode;
    }
    // }}}
    // {{{ searchFreeTextMode()
    function searchFreeTextMode()
    {
        return $this->_searchFreeTextMode;
    }
    // }}}
    // {{{ thumbnailSizes()
    function thumbnailSizes()
    {
        return array(
            'arkthumb_width' => $this->_thumbWidth,
            'arkthumb_height' => $this->_thumbHeight,
            'webthumb_width' => $this->_webThumbWidth,
            'webthumb_height' => $this->_webThumbHeight
        );
    }
    // }}}
    // {{{ maxUploadSize()
    function maxUploadSize()
    {
        return $this->_maxUploadSize;
    }
    // }}}
    // {{{ formMethod()
    function formMethod()
    {
        return $this->_formMethod;
    }
    // }}}
    // {{{ anonymousLogin()
    function anonymousLogin()
    {
        return $this->_anonymousLogin;
    }
    // }}}
    // {{{ anonymousUser()
    function anonymousUser()
    {
        return $this->_anonymousUser;
    }
    // }}}
    // {{{ anonymousPassword()
    function anonymousPassword()
    {
        return $this->_anonymousPassword;
    }
    // }}}
    // {{{ displayErrors()
    function displayErrors()
    {
        return $this->_displayErrors;
    }
    // }}}
    // {{{ codeVersion()
    function codeVersion()
    {
        return $this->_codeVersion;
    }
    // }}}
    // {{{ databaseVersion()
    function databaseVersion()
    {
        return $this->_databaseVersion;
    }
    // }}}
    // {{{ originalVersion()
    function originalVersion()
    {
        return $this->_originalVersion;
    }
    // }}}
    // {{{ module()
    function module($moduleId)
    {
        if (array_key_exists($moduleId, $this->_modules)) {
            return $this->_modules[$moduleId];
        }
        return ModuleConfig();
    }
    // }}}
    // {{{ moduleForItemKey()
    function moduleForItemKey($itemkey)
    {
        foreach ($this->_modules as $module) {
            if ($module->itemKey() == $itemkey) {
                return $module;
            }
        }
        return ModuleConfig();
    }
    // }}}
    // {{{ modules()
    function modules()
    {
        return $this->_modules;
    }
    // }}}
    // {{{ rootDir()
    function rootDir()
    {
        global $ark_root_dir;
        return $ark_root_dir;
    }
    // }}}
    // {{{ rootPath()
    function rootPath()
    {
        global $ark_root_path;
        return $ark_root_path;
    }
    // }}}
    // {{{ libDir()
    function libDir()
    {
        global $ark_lib_dir;
        return $ark_lib_dir;
    }
    // }}}
    // {{{ libPath()
    function libPath()
    {
        global $ark_lib_path;
        return $ark_lib_path;
    }
    // }}}
    // {{{ skinsDir()
    function skinsDir()
    {
        global $ark_skins_dir;
        return $ark_skins_dir;
    }
    // }}}
    // {{{ skinsPath()
    function skinsPath()
    {
        global $ark_skins_path;
        return $ark_skins_path;
    }
    // }}}
    // {{{ filesDir()
    function filesDir()
    {
        global $registered_files_dir;
        return $registered_files_dir;
    }
    // }}}
    // {{{ filesPath()
    function filesPath()
    {
        global $registered_files_path;
        return $registered_files_path;
    }
    // }}}
    // {{{ uploadDir()
    function uploadDir()
    {
        global $default_upload_dir;
        return $default_upload_dir;
    }
    // }}}
    // {{{ exportDir()
    function exportDir()
    {
        global $export_dir;
        return $export_dir;
    }
    // }}}
}
?>
