<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Module.php
*
* ARK Model Module
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/Module.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

final class Module extends AbstractResource
{
    private $site = '';
    private $itemkey = '';
    private $itemno = '';
    private $table = '';

    use ObjectTrait;

    protected function __construct(Database $db, $id)
    {
        parent::__construct($db, $id);
    }

    protected function loadConfig($config, Site $site = null)
    {
        parent::loadConfig($config);

        $this->site = $site;
        $this->typeCode = $config['module'];
        $this->type = $config['resource'];
        $this->table = $config['tbl'];
        $this->valid = true;
    }

    public function site()
    {
        return $this->site;
    }

    static public function get(Database $db, Site $site, $moduleId)
    {
        $module = new Module($db, $moduleId);
        $config = $db->getModule($moduleId);
        if (!$config) {
            throw new Error(1000);
        }
        $module->loadConfig($config, $site);
        return $module;
    }

    static public function getAll(Database $db, Site $site, $enabled = true)
    {
        $modules = array();
        $configs = $db->getSiteModules($site->id());
        foreach ($configs as $config) {
            $module = new Module($db, $config['module']);
            $module->loadConfig($config, $site);
            if ($module->isValid() && ($module->isEnabled() || !$enabled)) {
                $modules[] = $module;
            }
        }
        return $modules;
    }

}
