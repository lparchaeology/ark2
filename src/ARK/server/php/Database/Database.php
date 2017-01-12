<?php

/**
 * ARK Database
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Database;

use ARK\Error\ErrorException;
use ARK\Http\Error\InternalServerError;
use Silex\Application;

class Database
{
    private $app = null;
    private $modules = [];
    private $fragTypes = [];
    private $fragmentTables = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function data()
    {
        return $this->app['dbs']['data'];
    }

    public function sequence()
    {
        return $this->app['dbs']['data'];
    }

    public function core()
    {
        return $this->app['dbs']['core'];
    }

    public function user()
    {
        return $this->app['dbs']['user'];
    }

    public function generateItemSequence($module, $parent, $sequence)
    {
        $this->sequence()->startTransaction();
        // Check if there are any IDs to recycle first
        $sql = "
            SELECT *
            FROM ark_sequence_lock
            WHERE module = :module
            AND parent = :parent
            AND sequence = :sequence
            AND recycle = :recycle
        ".$this->sequence()->getPlatform()->$getWriteLockSQL();
        $params = [
            'module' => $module,
            'parent' => $parent,
            'sequence' => $sequence,
            'recycle' => true,
        ];
        $recycle = $this->data()->fetchAssoc($sql, $params);
        if ($recycle && $recycle['recycle']) {
            try {
                // If there is one, try to recycle it
                $sql = "
                    UPDATE ark_sequence_lock
                    SET recycle = :recycle
                    WHERE id = :id
                ";
                $reparams = [
                    'recycle' => false,
                    'id' => $recycle['id'],
                ];
                $this->sequence()->executeUpdate($sql, $reparams);
                $this->sequence()->commit();
                return $recycle['idx'];
            } catch (Exception $e) {
                // If recycle fails, just try issue the next one
                $this->sequence()->rollback();
                $this->sequence()->startTransaction();
            }
        }
        $sql = "
            SELECT *
            FROM ark_sequence
            WHERE module = :module
            AND parent = :parent
            AND sequence = :sequence
        ".$this->sequence()->getPlatform()->$getWriteLockSQL();
        unset($params['recycle']);
        $seq = $this->data()->fetchAssoc($sql, $params);
        if (!$seq) {
            // No sequence exists, so try create one
            try {
                $fields = ['module', 'parent', 'sequence', 'idx'];
                $rows = [[$module, $parent, $sequence, 1]];
                $this->insertRows($this->sequence(), 'ark_sequence', $fields, $rows);
                $this->insertRows($this->sequence(), 'ark_sequence_lock', $fields, $rows);
                $this->sequence()->commit();
                return 1;
            } catch (Exception $e) {
                $this->sequence()->rollback();
                throw new ErrorException(new InternalServerError(
                    'DB_SEQUENCE_CREATE',
                    'Creating index sequence failed',
                    "Creating the index sequence for Module $module Parent $parent Sequence $sequence failed"
                ));
            }
        }
        if ($seq['max'] && $seq['idx'] >= $seq['max']) {
            throw new ErrorException(new InternalServerError(
                'DB_SEQUENCE_EXHASTED',
                'Index sequence exhausted',
                "The index sequence for Module $module Parent $parent Sequence $sequence has reached maximum"
            ));
        }
        try {
            $sql = "
                UPDATE ark_sequence
                SET idx = idx + 1
                WHERE module = :module
                AND parent = :parent
                AND sequence = :sequence
            ";
            $this->sequence()->executeUpdate($sql, $params);
            $fields = ['module', 'parent', 'sequence', 'idx'];
            $rows = [[$module, $parent, $sequence, 1]];
            $this->insertRows($this->sequence(), 'ark_sequence_lock', $fields, $rows);
            $this->sequence()->commit();
            return $seq['idx'] + 1;
        } catch (Exception $e) {
            $this->sequence()->rollback();
            throw new ErrorException(new InternalServerError(
                'DB_SEQUENCE_INCREMENT',
                'Increment index sequence failed',
                "Incrementing the index sequence failed for Module $module Parent $parent Sequence $sequence"
            ));
        }
    }

    private function loadModules()
    {
        if ($this->modules) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_module
        ";
        $modules = $this->core()->fetchAll($sql, array());
        foreach ($modules as $module) {
            $this->modules[$module['module']] = $module;
        }
    }

    public function getModuleTable($module)
    {
        $this->loadModules();
        return $this->modules[$module]['tbl'];
    }

    public function getModule($module)
    {
        $this->loadModules();
        $module = strtolower($module);
        if (isset($this->modules[$module])) {
            return $this->modules[$module];
        }
        foreach ($this->modules as $mod) {
            if ($mod['resource'] == $module) {
                return $mod;
            }
        }
        return null;
    }

    public function getModules()
    {
        $this->loadModules();
        return $this->modules;
    }

    private function loadFragmentTypes()
    {
        if ($this->fragTypes) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_fragment_type
        ";
        $fragTypes = $this->core()->fetchAll($sql, []);
        foreach ($fragTypes as $fragType) {
            $this->fragTypes[$fragType['type']] = $fragType;
            if ($fragType['tbl']) {
                $this->fragmentTables[] = $fragType['tbl'];
            }
        }
    }

    private function getFragmentTable($fragType)
    {
        $this->loadFragmentTypes();
        return $this->fragTypes[$fragType]['tbl'];
    }

    public function getFragmentTables()
    {
        $this->loadFragmentTypes();
        return $this->fragmentTables;
    }

    public function getSubtypeEntities($module)
    {
        $sql = "
            SELECT ark_schema_subtype.subtype, ark_schema_subtype.entity
            FROM ark_schema, ark_schema_subtype
            WHERE ark_schema.module = :module
            AND ark_schema.enabled = true
            AND ark_schema.subtype_entities = true
            AND ark_schema_subtype.schma = ark_schema.schma
            AND ark_schema_subtype.enabled = true
        ";
        $params = array(
            ':module' => $module,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getSubmodules($module, $schemaId)
    {
        $sql = "
            SELECT *
            FROM ark_module_submodule, ark_module
            WHERE ark_module_submodule.module = :module
            AND ark_module_submodule.schema_id = :schema_id
            AND ark_module_submodule.submodule = ark_module.module
        ";
        $params = array(
            ':module' => $module,
            ':schema_id' => $schemaId,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getSubmodule($module, $schemaId, $submodule)
    {
        $sql = "
            SELECT *
            FROM ark_module_submodule, ark_module
            WHERE ark_module_submodule.module = :module
            AND ark_module_submodule.schema_id = :schema_id
            AND ark_module_submodule.submodule = :submodule
            AND ark_module.module = ark_module_submodule.submodule
        ";
        $params = array(
            ':module' => $module,
            ':schema_id' => $schemaId,
            ':submodule' => $submodule,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getXmiModules($module, $schemaId)
    {
        $sql = "
            SELECT *
            FROM ark_module_xmi, ark_module
            WHERE ark_module_xmi.module = :module
            AND ark_module_xmi.schema_id = :schema_id
            AND ark_module.module = ark_module_xmi.module
        ";
        $params = array(
            ':module' => $module,
            ':schema_id' => $schemaId,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getModuleSchema($module, $schemaId)
    {
        $sql = "
            SELECT
                ark_module.*,
                ark_module_schema.*, ark_schema_subtype.keyword AS modtype_keyword,
                ark_schema_subtype.*, ark_schema_subtype.keyword AS modtype_keyword,
                ark_schema_attribute.attribute
            FROM ark_module
            INNER JOIN ark_module_schema
                ON ark_module_schema.module = ark_module.module
                AND ark_module_schema.schema_id = :schema_id
                AND ark_module_schema.enabled = true
            INNER JOIN ark_schema_subtype
                ON ark_schema_subtype.module = ark_module_schema.module
                AND ark_schema_subtype.schema_id = ark_module_schema.schema_id
                AND (ark_schema_subtype.enabled = true OR ark_schema_subtype.modtype = '')
            LEFT JOIN ark_schema_attribute
                ON ark_schema_attribute.module = ark_schema_subtype.module
                AND ark_schema_attribute.schema_id = ark_schema_subtype.schema_id
                AND ark_schema_attribute.modtype = ark_schema_subtype.modtype
                AND ark_schema_attribute.enabled = true
            WHERE ark_module.module = :module
            AND ark_module.enabled = true
        ";
        $params = array(
            ':module' => strtolower($module),
            ':schema_id' => strtolower($schemaId),
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getModuleSchemas($module)
    {
        $sql = "
            SELECT *
            FROM ark_module_schema
            WHERE module = :module
        ";
        $params = array(
            ':module' => strtolower($module),
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getModtypes($module, $schema = null)
    {
        $sql = "
            SELECT *
            FROM ark_schema_subtype
            WHERE module = :module
        ";
        $params[':module'] = $module;
        if ($schema) {
            $sql .= "
                AND schema_id = :schema
            ";
            $params[':schema'] = $schema;
        }
        return $this->core()->fetchAll($sql, $params);
    }

    public function getLayout($layout)
    {
        $sql = "
            SELECT *
            FROM ark_view_layout
            WHERE layout = :layout
        ";
        $params = array(
            ':layout' => $layout,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getElement($element)
    {
        $sql = "
            SELECT *,
                   ark_view_element.type AS type,
                   ark_view_element_type.class AS class,
                   ark_view_layout.class AS layout_class
            FROM ark_view_element,
                 ark_view_element_type
            LEFT JOIN
                ark_view_field ON ark_view_field.field = :element
            LEFT JOIN ark_view_layout
                ON ark_view_layout.layout = :element
            LEFT JOIN cor_conf_link
                ON cor_conf_link.link = :element
            LEFT JOIN cor_conf_subform
                ON cor_conf_subform.subform = :element
            WHERE ark_view_element.element = :element
                AND ark_view_element.type = ark_view_element_type.type
        ";
        $params = array(
            ':element' => $element,
        );
        $results = $this->core()->fetchAssoc($sql, $params);
        if (empty($results['class']) && !empty($results['layout_class'])) {
            $results['class'] = $results['layout_class'];
        }
        return $results;
    }

    public function getField($field)
    {
        $sql = "
            SELECT *
            FROM ark_view_field, ark_module_attribute
            WHERE field = :field
            AND ark_view_field.attribute = ark_module_attribute.attribute
        ";
        $params = array(
            ':field' => $field,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getSubform($subform)
    {
        $sql = "
            SELECT *
            FROM cor_conf_subform
            WHERE subform = :subform
        ";
        $params = array(
            ':subform' => $subform,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getGroupForModule($group, $module, $modtype = null)
    {
        $sql = "
            SELECT ark_view_group.*, ark_view_element.type AS child_type
            FROM ark_view_group, ark_view_element
            WHERE ark_view_group.element = :element
            AND (ark_view_group.modtype = :module OR ark_view_group.modtype = :modtype OR ark_view_group.modtype = :cor)
            AND ark_view_group.enabled = :enabled
            AND ark_view_group.child = ark_view_element.element
            ORDER BY ark_view_group.row, ark_view_group.col, ark_view_group.seq
        ";
        $params = array(
            ':element' => $group,
            ':modtype' => $modtype,
            ':module' => $module,
            ':cor' => 'cor',
            ':enabled' => true,
        );
        if (!$modtype) {
            $params[':modtype'] = 'cor';
        }
        return $this->core()->fetchAll($sql, $params);
    }

    public function getGroup($element, $childType = null, /*bool*/ $enabled = true)
    {
        $sql = "
            SELECT ark_view_group.*, ark_view_element.type AS child_type
            FROM ark_view_group, ark_view_element
            WHERE ark_view_group.element = :element
            AND ark_view_group.child = ark_view_element.element
            ORDER BY ark_view_group.row, ark_view_group.col, ark_view_group.seq
        ";
        $params[':element'] = $element;
        if ($childType) {
            $sql .= ' AND ark_view_element.type = :type';
            $params[':type'] = $childType;
        }
        if ($enabled === true || $enabled === false) {
            $sql .= ' AND ark_view_group.enabled = :enabled';
            $params[':enabled'] = $enabled;
        }
        return $this->core()->fetchAll($sql, $params);
    }

    public function getRule($vldRule)
    {
        $sql = "
            SELECT *
            FROM cor_conf_vld_rule
            WHERE vld_rule = :vld_rule
        ";
        $params = array(
            ':vld_rule' => $vldRule,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getElementValidationGroup($element, $vldRole)
    {
        $sql = "
            SELECT *
            FROM cor_conf_element_vld
            WHERE element = :element
            AND vld_role = :vld_role
        ";
        $params = array(
            ':element' => $element,
            ':vld_role' => $vldRole,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getElementValidationGroups($element)
    {
        $sql = "
            SELECT *
            FROM cor_conf_element_vld
            WHERE element = :element
        ";
        $params = array(
            ':element' => $element,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getValidationGroup($vldGroup)
    {
        $sql = "
            SELECT *
            FROM cor_conf_vld_group
            WHERE vld_group = :vld_group
        ";
        $params = array(
            ':vld_group' => $vldGroup,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getConditions($element)
    {
        $sql = "
            SELECT *
            FROM cor_conf_condition
            WHERE element = :element
        ";
        $params = array(
            ':element' => $element,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getLink($link)
    {
        $sql = "
            SELECT *
            FROM cor_conf_link
            WHERE link = :link
        ";
        $params = array(
            ':link' => $link,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getOption($element, $option)
    {
        $sql = "
            SELECT *
            FROM ark_view_option
            WHERE element = :element
            AND option = :option
        ";
        $params = array(
            ':element' => $element,
            ':option' => $option,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getOptions($element)
    {
        $sql = "
            SELECT *
            FROM ark_view_option
            WHERE element = :element
        ";
        $params = array(
            ':element' => $element,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getModuleProperties($module, $schema)
    {
        $sql = "
        SELECT *, ark_schema_attribute.format, ark_schema_attribute.keyword, ark_format.keyword as format_keyword
        FROM ark_schema_attribute
        LEFT JOIN ark_format ON ark_format.format = ark_schema_attribute.format
        LEFT JOIN ark_format_float ON ark_format_float.format = ark_format.format_type
        LEFT JOIN ark_format_integer ON ark_format_integer.format = ark_format.format_type
        LEFT JOIN ark_format_string ON ark_format_string.format = ark_format.format_type
        LEFT JOIN ark_fragment_type ON ark_fragment_type.fragment_type = ark_format.fragment_type
        WHERE ark_schema_attribute.module = :module
        AND ark_schema_attribute.schema_id = :schema
        ";
        $params = array(
            ':module' => $module,
            ':schema' => $schema,
        );
        $results = $this->core()->fetchAll($sql, $params);
        foreach ($results as $result) {
            if ((!isset($result['keyword']) || !$result['keyword']) && isset($result['format_keyword'])) {
                $result['keyword'] = $result['format_keyword'];
            }
        }
        return $results;
    }

    public function getModuleProperty($module, $schema, $modtype, $attribute)
    {
        $sql = "
            SELECT *, ark_schema_attribute.format, ark_schema_attribute.keyword, ark_format.keyword as format_keyword
            FROM ark_schema_attribute
            LEFT JOIN ark_format ON ark_format_float.format = ark_schema_attribute.format
            LEFT JOIN ark_format_float ON ark_format_float.format = ark_format.format_type
            LEFT JOIN ark_format_integer ON ark_format_integer.format = ark_format.format_type
            LEFT JOIN ark_format_string ON ark_format_string.format = ark_format.format_type
            LEFT JOIN ark_fragment_type ON ark_fragment_type.fragment_type = ark_format.fragment_type
            WHERE ark_schema_attribute.module = :module
            AND ark_schema_attribute.schema = :schema
            AND (ark_schema_attribute.modtype = :modtype OR ark_schema_attribute.modtype = :module)
            AND ark_schema_attribute.attribute = :attribute
        ";
        $params = array(
            ':module' => $module,
            ':schema' => $schema,
            ':modtype' => $modtype,
            ':attribute' => $attribute,
        );
        $result = $this->core()->fetchAssoc($sql, $params);
        if ((!isset($result['keyword']) or !$result['keyword']) && isset($result['format_keyword'])) {
            $result['keyword'] = $result['format_keyword'];
        }
        return $result;
    }

    public function getFormatProperties($format)
    {
        $sql = "
            SELECT *, ark_format_attribute.format, ark_format_attribute.keyword, ark_format.keyword as format_keyword
            FROM ark_format_attribute
            LEFT JOIN ark_format ON ark_format.format = ark_format_attribute.format
            LEFT JOIN ark_format_float ON ark_format_float.format = ark_format.format_type
            LEFT JOIN ark_format_integer ON ark_format_integer.format = ark_format.format_type
            LEFT JOIN ark_format_string ON ark_format_string.format = ark_format.format_type
            LEFT JOIN ark_fragment_type ON ark_fragment_type.fragment_type = ark_format.fragment_type
            WHERE ark_format_attribute.parent_format = :format
            ORDER BY ark_format_attribute.seq
        ";
        $params = array(
            ':format' => $format,
        );
        $results = $this->core()->fetchAll($sql, $params);
        foreach ($results as $result) {
            if ((!isset($result['keyword']) || !$result['keyword']) && isset($result['format_keyword'])) {
                $result['keyword'] = $result['format_keyword'];
            }
        }
        return $results;
    }

    public function getFormatProperty($format, $attribute)
    {
        $sql = "
            SELECT *, ark_format_attribute.format, ark_format_attribute.keyword, ark_format.keyword as format_keyword
            FROM ark_format_attribute
            LEFT JOIN ark_format ON ark_format.format = ark_format_attribute.format
            LEFT JOIN ark_format_float ON ark_format_float.format = ark_format.format_type
            LEFT JOIN ark_format_integer ON ark_format_integer.format = ark_format.format_type
            LEFT JOIN ark_format_string ON ark_format_string.format = ark_format.format_type
            LEFT JOIN ark_fragment_type ON ark_fragment_type.fragment_type = ark_format.fragment_type
            WHERE ark_format_attribute.parent_format = :format
            AND ark_format_attribute.attribute = :attribute
        ";
        $params = array(
            ':format' => $format,
            ':attribute' => $attribute,
        );
        $result = $this->core()->fetchAssoc($sql, $params);
        if ((!isset($result['keyword']) or !$result['keyword']) && isset($result['format_keyword'])) {
            $result['keyword'] = $result['format_keyword'];
        }
        return $result;
    }

    public function getFormat($format)
    {
        $sql = "
            SELECT *
            FROM ark_format
            LEFT JOIN ark_format_float ON ark_format_float.format = ark_format.format_type
            LEFT JOIN ark_format_integer ON ark_format_integer.format = ark_format.format_type
            LEFT JOIN ark_format_string ON ark_format_string.format = ark_format.format_type
            LEFT JOIN ark_fragment_type ON ark_fragment_type.fragment_type = ark_format.fragment_type
            WHERE ark_format.format = :format
        ";
        $params = array(
            ':format' => $format,
        );
        return $this->core()->fetchAssoc($sql, $params);
    }

    public function getAllowedValues($format)
    {
        $sql = "
            SELECT *
            FROM ark_format_value
            WHERE format = :format
        ";
        $params = array(
            ':format' => $format,
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getTranslations($domain = null)
    {
        $sql = "
            SELECT *
            FROM ark_translation
        ";
        $params = array();
        if ($domain) {
            $sql .= "
                WHERE domain = :domain
            ";
            $params[':domain'] = $domain;
        }
        return $this->core()->fetchAll($sql, $params);
    }

    public function getTranslationMessages($language, $domain = null)
    {
        $sql = "
            SELECT *
            FROM ark_translation_message
            WHERE language = :language
        ";
        $params[':language'] = $language;
        if ($domain) {
            $sql .= "
                AND domain = :domain
            ";
            $params[':domain'] = $domain;
        }
        return $this->core()->fetchAll($sql, $params);
    }

    public function getActorNames()
    {
        $sql = "
            SELECT *
            FROM ark_item_actor, ark_fragment_string
            WHERE ark_fragment_string.module = :module
            AND ark_fragment_string.item = ark_item_actor.id
            AND ark_fragment_string.attribute = :attribute
        ";
        $params = array(
            ':module' => 'act',
            ':attribute' => 'name',
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getFlashes($language)
    {
        $sql = "
            SELECT *
            FROM ark_config_flash
            WHERE language = :language
            AND active = :active
        ";
        $params = array(
            ':language' => $language,
            ':active' => true,
        );
        return $this->core()->fetchAll($sql, $params);
    }
}
