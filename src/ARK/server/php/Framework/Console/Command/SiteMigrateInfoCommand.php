<?php

/**
 * ARK Console Command.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Console\Command;

use ARK\ARK;
use ARK\Database\Console\Command\DatabaseCommand;

class SiteMigrateInfoCommand extends DatabaseCommand
{
    protected $source;
    protected $modules = [];
    protected $itemkeys = [];
    protected $sites = [];
    protected $users = [];
    protected $actors = [];
    protected $types = [];
    protected $tables = [];
    protected $frags = [];

    protected function configure() : void
    {
        $this->setName('site:migrate:info')
            ->setDescription('Analyse the migration mapping for an ARK 1 site');
    }

    protected function doExecute() : void
    {
        $sourceConfig = $this->chooseDatabaseConfig();
        if (!is_array($sourceConfig)) {
            return;
        }
        $this->source = $this->getConnection($sourceConfig);
        $this->source->beginTransaction();
        $this->analyse();
        $this->report();
    }

    protected function analyse() : void
    {
        // SITES
        $this->write('Analysing Sites...');
        $sites = $this->source->fetchAllTable('cor_tbl_ste');
        foreach ($sites as $site) {
            $site['modules'] = [];
            $site['items'] = 0;
            $this->sites[$site['id']] = $site;
        }

        // MODULES
        $this->write('Analysing Modules...');
        $this->modules = $this->source->fetchAllTable('cor_tbl_module');
        foreach ($this->modules as &$module) {
            $mod = $module['shortform'];
            if ($mod === 'cor') {
                continue;
            }
            $this->itemkeys[] = $module['itemkey'];
            $module['table'] = $mod.'_tbl_'.$mod;
            $module['rows'] = $this->source->countRows($module['table']);
            $module['modtype'] = $mod.'type';
            $module['lut'] = $mod.'_lut_'.$module['modtype'];
            $module['modtypes'] = [];
            if ($this->source->tableExists($module['lut'])) {
                $modtypes = $this->source->fetchAllTable($module['lut']);
                foreach ($modtypes as $modtype) {
                    if (isset($modtype[$module['modtype']])) {
                        $module['modtypes'][] = mb_strtolower($modtype[$module['modtype']]);
                    }
                }
            } else {
                $module['modtype'] = null;
                $module['lut'] = null;
                $module['modtypes'] = [];
            }
            foreach (array_keys($this->sites) as $id) {
                $count = $this->countItems($module['table'], $id);
                $this->sites[$id]['modules'][$mod] = $count;
                $this->sites[$id]['items'] += $count;
            }
        }
        unset($module);

        // USERS
        $this->write('Analysing Users...');
        if ($this->source->table('cor_tbl_users')->hasColumn('itemvalue')) {
            $sql = '
                SELECT cor_tbl_users.*, abk_tbl_abk.ste_cd, abk_lut_abktype.abktype
                FROM cor_tbl_users
                LEFT JOIN abk_tbl_abk
                ON cor_tbl_users.itemvalue = abk_tbl_abk.abk_cd
                LEFT JOIN abk_lut_abktype
                ON abk_tbl_abk.abktype = abk_lut_abktype.abktype
            ';
            $users = $this->source->fetchAll($sql);
        } else {
            $users = $this->source->fetchAllTable('cor_tbl_users');
        }
        foreach ($users as $row) {
            $user['user'] = $row['id'];
            $user['username'] = $row['username'];
            $user['actor'] = $row['itemvalue'] ?? null;
            $user['name'] = $row['firstname'].' '.$row['lastname'];
            $user['email'] = $row['email'] ? $row['email'] : null;
            $user['site'] = $row['ste_cd'] ?? null;
            $user['audit'] = false;
            $user['action'] = false;
            $user['groups'] = [];
            $user['enabled'] = (bool) $row['account_enabled'];
            $this->users[$user['user']] = $user;
        }
        $sql = '
            SELECT cor_tbl_users.id, cor_lvu_groups.group_define_name
            FROM cor_tbl_users, cor_lvu_perm_users, cor_lvu_groupusers, cor_lvu_groups
            WHERE cor_tbl_users.id = cor_lvu_perm_users.auth_user_id
            AND cor_lvu_perm_users.perm_user_id = cor_lvu_groupusers.perm_user_id
            AND cor_lvu_groupusers.group_id = cor_lvu_groups.group_id
        ';
        $usergroups = $this->source->fetchAll($sql);
        foreach ($usergroups as $user) {
            $this->users[$user['id']]['groups'][] = $user['group_define_name'];
        }

        // ACTORS
        $this->write('Analysing Actors...');
        $sql = '
            SELECT *
            FROM cor_lut_txttype
            WHERE cor_lut_txttype.txttype = ?
        ';
        $txttype = $this->source->fetchAssoc($sql, ['name']);
        $sql = '
            SELECT abk_tbl_abk.*, abk_lut_abktype.abktype, cor_tbl_txt.txt
            FROM abk_tbl_abk
            LEFT JOIN abk_lut_abktype
            ON abk_tbl_abk.abktype = abk_lut_abktype.id
            LEFT JOIN cor_tbl_txt
            ON cor_tbl_txt.itemkey = ?
            AND cor_tbl_txt.itemvalue = abk_tbl_abk.abk_cd
            AND cor_tbl_txt.txttype = ?
        ';
        $actors = $this->source->fetchAll($sql, ['abk_cd', $txttype['id']]);
        foreach ($actors as $row) {
            $actor['actor'] = $row['abk_cd'];
            $actor['name'] = $row['txt'];
            $actor['site'] = $row['ste_cd'];
            $actor['type'] = $row['abktype'];
            $actor['action'] = false;
            $this->actors[$row['abk_cd']] = $actor;
        }

        // ACTIONS
        $this->write('Analysing Actions...');
        $this->buildTypes('action');
        $sql = '
            SELECT cor_tbl_action.*, cor_lut_actiontype.actiontype
            FROM cor_tbl_action, cor_lut_actiontype
            WHERE cor_tbl_action.actiontype = cor_lut_actiontype.id
        ';
        $this->summariseFrags('action', $sql);

        // ATTRIBUTES
        $this->write('Analysing Attributes...');
        $sql = '
            SELECT cor_lut_attribute.*, cor_lut_attributetype.attributetype, cor_lut_attributetype.module
            FROM cor_lut_attribute, cor_lut_attributetype
            WHERE cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ';
        $this->buildTypes('attribute', $sql);
        $sql = '
            SELECT cor_tbl_attribute.*, cor_lut_attribute.attribute, cor_lut_attributetype.attributetype
            FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
            WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
            AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
        ';
        $this->summariseFrags('attribute', $sql);

        // FILES
        $this->write('Analysing Files...');
        $this->buildTypes('file');
        $sql = '
            SELECT cor_tbl_file.*, cor_lut_filetype.filetype
            FROM cor_tbl_file, cor_lut_file, cor_lut_filetype
            WHERE cor_tbl_file.file = cor_lut_file.id
            AND cor_lut_file.filetype = cor_lut_filetype.id
        ';
        $this->summariseFrags('file', $sql);

        // DATE
        $this->write('Analysing Date Fragments...');
        $this->buildTypes('date');
        $this->summariseTypeFrags('date');

        // NUMBER
        $this->write('Analysing Number Fragments...');
        $this->buildTypes('number');
        $this->summariseTypeFrags('number');

        // TEXT
        $this->write('Analysing Text Fragments...');
        $this->buildTypes('txt');
        $this->summariseTypeFrags('txt');

        // SPAN
        $this->write('Analysing Spans...');
        $this->buildTypes('span');
        $this->summariseTypeFrags('span');

        // XMI
        $this->write('Analysing XMIs...');
        $frags = $this->source->fetchAllTable('cor_tbl_xmi');
        foreach ($frags as $frag) {
            $mod = $frag['itemkey'];
            $xmi = $frag['xmi_itemkey'];
            if (isset($this->frags[$mod]['xmi'][$xmi])) {
                $this->frags[$mod]['xmi'][$xmi] += 1;
            } else {
                $this->frags[$mod]['xmi'][$xmi] = 1;
            }
            if (isset($this->frags[$xmi]['xmi'][$mod])) {
                $this->frags[$xmi]['xmi'][$mod] += 1;
            } else {
                $this->frags[$xmi]['xmi'][$mod] = 1;
            }
            if ($mod === 'abk_cd') {
                $this->actors[$frag['itemvalue']]['action'] = true;
            }
            if ($xmi === 'abk_cd') {
                $this->actors[$frag['xmi_itemvalue']]['action'] = true;
            }
        }

        // USERS / ACTORS
        foreach ($this->users as $id => &$user) {
            if (isset($user['actor'])) {
                $user['action'] = $this->actors[$user['actor']]['action'] ?? false;
            }
            if (!isset($user['user'])) {
                $user['user'] = $id;
                $user['username'] = null;
                $user['name'] = null;
                $user['email'] = null;
                $user['groups'] = [];
                $user['actor'] = null;
                $user['site'] = null;
                $user['audit'] = $user['audit'] ?? false;
                $user['action'] = $user['action'] ?? false;
            }
        }
        unset($user);
    }

    protected function report() : void
    {
        // REPORT SITES
        $this->write("\nSITES");
        $headers = ['ID', 'Description', 'Items'];
        $rows = [];
        foreach ($this->sites as $site) {
            $rows[] = [$site['id'], $site['description'], $site['items']];
        }
        $this->writeTable($headers, $rows);

        // REPORT MODULES
        $this->write("\nMODULES");
        $headers = ['Code', 'Description', 'Modtype', 'Table', 'Items'];
        $rows = [];
        foreach ($this->modules as $module) {
            if (isset($module['shortform']) && $module['shortform'] !== 'cor') {
                $rows[] = [$module['shortform'], $module['description'], $module['modtype'], $module['table'], $module['rows']];
            }
        }
        $this->writeTable($headers, $rows);

        // REPORT SITE MODULES
        $this->write("\nMODULES AS USED BY SITES");
        $headers = ['ID', 'Module', 'Items'];
        $rows = [];
        foreach ($this->sites as $site) {
            foreach ($site['modules'] as $module => $items) {
                if ($items > 0) {
                    $rows[] = [$site['id'], $module, $items];
                }
            }
        }
        $this->writeTable($headers, $rows);

        // REPORT USERS
        $this->write("\nUSERS");
        $headers = ['User', 'Username', 'Email', 'Name', 'Groups', 'Actor', 'Site', 'Audit', 'Action'];
        $rows = [];
        foreach ($this->users as $id => $user) {
            $rows[] = [
                $user['user'],
                $user['username'],
                $user['email'],
                $user['name'],
                implode(', ', $user['groups']),
                $user['actor'],
                $user['site'],
                $user['audit'],
                $user['action'],
            ];
        }
        $this->writeTable($headers, $rows);
        $this->write('');

        // REPORT ACTORS
        $this->write("\nACTORS");
        $headers = ['Actor', 'Name', 'Site', 'Action'];
        $rows = [];
        foreach ($this->users as $id => $user) {
            $rows[] = [
                $user['actor'],
                $user['name'],
                $user['site'],
                $user['action'],
            ];
        }
        $this->writeTable($headers, $rows);
        $this->write('');

        // REPORT FRAG SCHEMA
        $this->write("\nTYPES AS USED BY MODULES");
        foreach ($this->modules as &$module) {
            if (!isset($module['shortform']) || $module['shortform'] === 'cor' || !isset($this->frags[$module['itemkey']])) {
                continue;
            }
            $module['frags'] = $this->frags[$module['itemkey']];
            ksort($module['frags']);
            $this->write("\n".$module['shortform']);
            $headers = ['Class', 'Field', 'Count'];
            $rows = [];
            foreach ($module['frags'] as $class => &$fields) {
                ksort($fields);
                foreach ($fields as $field => $count) {
                    $rows[] = [$class, $field, $count];
                }
            }
            $this->writeTable($headers, $rows);
        }

        // REPORT FULL SCHEMA
        $this->write("\nTYPES AS DEFINED BY MODULES");
        ksort($this->types);
        foreach ($this->types as $module => &$types) {
            $this->write("\n".$module);
            $headers = ['Class', 'Field', 'Value', 'Count'];
            $rows = [];
            foreach ($types as $class => &$fields) {
                ksort($fields);
                foreach ($fields as $field => &$values) {
                    ksort($values);
                    foreach ($values as $value => $count) {
                        $rows[] = [$class, $field, $value, $count];
                    }
                }
            }
            $this->writeTable($headers, $rows);
        }
    }

    private function getItemkey($frag)
    {
        if (!isset($frag['itemkey'])) {
            return 'error';
        }
        if (in_array($frag['itemkey'], $this->itemkeys, true)) {
            return $frag['itemkey'];
        }
        if (!in_array($frag['itemkey'], $this->tables, true) && $this->source->tableExists($frag['itemkey'])) {
            $this->tables[] = $frag['itemkey'];
        }
        if (in_array($frag['itemkey'], $this->tables, true)) {
            $tbl = $frag['itemkey'];
            $sql = "
                SELECT *
                FROM $tbl
                WHERE id = ?
            ";
            $parent = $this->source->fetchAssoc($sql, [$frag['itemvalue']]);

            return $this->getItemkey($parent);
        }

        return $frag['itemkey'];
    }

    private function countItems($table, $site = null)
    {
        $sql = "
            SELECT COUNT(*)
            FROM $table
        ";
        $parms = [];
        if ($site) {
            $sql .= 'WHERE ste_cd = ?';
            $parms[] = $site;
        }

        return $this->source->executeQuery($sql, $parms)->fetch()['COUNT(*)'];
    }

    private function countTypeFrags($type, $field = null)
    {
        if ($type === 'file') {
            return null;
        }
        $typename = $type.'type';
        $sql = "
            SELECT COUNT(*)
            FROM cor_tbl_$type, cor_lut_$typename
            WHERE cor_tbl_$type.$typename = cor_lut_$typename.id
        ";
        $parms = [];
        if ($field) {
            $sql .= "AND cor_lut_$typename.$typename = ?";
            $parms[] = $field;
        }

        return $this->source->executeQuery($sql, $parms)->fetch()['COUNT(*)'];
    }

    private function countAttributeFrags($field, $value = null)
    {
        $sql = '
            SELECT COUNT(*)
            FROM cor_tbl_attribute, cor_lut_attribute, cor_lut_attributetype
            WHERE cor_tbl_attribute.attribute = cor_lut_attribute.id
            AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
            AND cor_lut_attributetype.attributetype = ?
        ';
        $parms[] = $field;
        if ($value) {
            $sql .= 'AND cor_lut_attribute.attribute = ?';
            $parms[] = $value;
        }

        return $this->source->executeQuery($sql, $parms)->fetch()['COUNT(*)'];
    }

    private function summariseTypeFrags($type, $field = null) : void
    {
        $typename = $type.'type';
        $sql = "
            SELECT cor_tbl_$type.*, cor_lut_$typename.$typename
            FROM cor_tbl_$type, cor_lut_$typename
            WHERE cor_tbl_$type.$typename = cor_lut_$typename.id
        ";
        $parms = [];
        if ($field) {
            $sql .= "AND $typename = ?";
            $parms[] = $field;
        }
        $this->summariseFrags($type, $sql);
    }

    private function summariseFrags($type, $sql, $parms = []) : void
    {
        $frags = $this->source->fetchAll($sql, $parms);
        $typename = $type.'type';
        foreach ($frags as $frag) {
            $module = $this->getItemkey($frag);
            $field = $frag[$typename];
            if (isset($this->frags[$module][$type][$field])) {
                $this->frags[$module][$type][$field] += 1;
            } else {
                $this->frags[$module][$type][$field] = 1;
            }
            if (isset($frag['actor_itemvalue'])) {
                $this->actors[$frag['actor_itemvalue']]['action'] = true;
            }
            if (isset($frag['cre_by'])) {
                $this->users[$frag['cre_by']]['audit'] = true;
            }
        }
    }

    private function buildTypes($type, $sql = '') : void
    {
        $typename = $type.'type';
        $lut = 'cor_lut_'.$typename;
        $tbl = 'cor_tbl_'.$typename;
        if ($sql) {
            $classes = $this->source->fetchAll($sql);
        } else {
            $classes = $this->source->fetchAllTable($lut);
        }
        foreach ($classes as $class) {
            $module = ($class['module'] ?? 'cor');
            $field = $class[$typename];
            if (isset($class[$type])) {
                $this->types[$module][$type][$field][$class[$type]] = $this->countAttributeFrags($field, $class[$type]);
            } else {
                $this->types[$module][$type][$field][''] = $this->countTypeFrags($type, $field);
            }
        }
    }
}
