<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Site.php
*
* ARK Model Site
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/Site.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

final class Site extends AbstractResource
{
    use ObjectTrait;

    private $modules = null;

    protected function __construct(Database $db, $site)
    {
        parent::__construct($db, $site);
    }

    protected function loadConfig($config)
    {
        parent::loadConfig($config);
        $this->typeCode = $config['module'];
        $this->type = $config['url'];
        $this->valid = true;
    }

    public function modules()
    {
        if ($this->modules == null) {
            $modules = Module::getAll($this->db, $this->id());
            $this->modules = ($modules ? $modules : array());
        }
        return $this->modules;
    }

    public static function get(Database $db, $siteCode)
    {
        $site = new Site($db, $siteCode);
        $config = $db->getSite($siteCode);
        if (!$config) {
            throw new Error(1000);
        }
        $site->loadConfig($config);
        return $site;
    }

    public static function getAll(Database $db)
    {
        $sites = array();
        $configs = $db->getSites();
        foreach ($configs as $config) {
            $site = new Site($db, $config['ste_cd']);
            $site->loadConfig($config);
            if ($site->isValid()) {
                $sites[] = $site;
            }
        }
        return $sites;
    }
}
