<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* ado.php
*
* ARK Data Objects (ADO)
* A wrapper class for low-level ARK database access via PDO. This class performs
* low-level database functions, i.e. with no knowledge of the ARK database Schema.
* This class also catches PDO erros and handles them in an ARK-friendly way.
*
* PHP version 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2015  L - P : Heritage LLP.
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  2015 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/ado.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;
use PDO, PDOException;

class ADO
{
    private $_pdo = NULL;
    private $_lastException = NULL;

    // {{{ __construct()

    /**
     * Creates an ADO object, connects to a MySQL server, selects the specified
     * DB and sets the client set to UTF8
     *
     * @param string $sql_server  the MySQL server to connect to
     * @param string $sql_user  the MySQL user to connect with
     * @param string $sql_pwd  the password of the $sql_user
     * @param string $ark_db  the name of the database to select
     * @author Guy Hunt
     * @author Stuart Eve
     * @since 2.0
     */
    function __construct($sql_server, $sql_user, $sql_pwd, $ark_db)
    {
        // connect to the DB server
        try {
            $this->_pdo = new PDO("mysql:host=$sql_server;dbname=$ark_db;charset=utf8", $sql_user, $sql_pwd,
                                   array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            //  now set the appropriate exception modes, etc.
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $ex) {
            $this->_lastException = $ex;
            // make up error string
            $err = "Error making db connection to $sql_server ";
            $password = "";
            foreach (str_split($sql_pwd) as $id => $dummy){
                if($id==0 || $id == (strlen($sql_pwd)-1)){
                    $password .= $dummy;
                } else {
                    $password .="*";
                }
            }
            $err .= "using user: $sql_user and password $password server returned error:<br/>";
            $this->_showError($ex->getMessage(),$err);
        }
    }

    // }}}
    // {{{ beginTransaction()

    /**
    * Starts a PDO transaction and handles any exceptions
    *
    * @return bool success - TRUE on success or FALSE on failure
    * @author John Layt
    * @since 2.0
    */
    function beginTransaction()
    {
        $result = FALSE;
        try {
            $result = $this->_pdo->beginTransaction();
        } catch (PDOException $ex) {
            $this->_lastException = $ex;
            $result = FALSE;
        }
        return $result;
    }

    // }}}
    // {{{ inTransaction()

    /**
    * Returns if inside a PDO transaction
    *
    * @return bool inTransaction - TRUE if in a transaction or FALSE if not
    * @author John Layt
    * @since 2.0
    */
    function inTransaction()
    {
        $result = FALSE;
        try {
            $result = $this->_pdo->beginTransaction();
        } catch (PDOException $ex) {
            $this->_lastException = $ex;
            $result = FALSE;
        }
        return $result;
    }

    // }}}
    // {{{ commit()

    /**
    * Commits a PDO transaction and handles any exceptions
    *
    * @return bool success - TRUE on success or FALSE on failure
    * @author John Layt
    * @since 2.0
    */
    function commit()
    {
        $result = FALSE;
        try {
            $result = $this->_pdo->commit();
        } catch (PDOException $ex) {
            $this->_lastException = $ex;
            $result = FALSE;
        }
        return $result;
    }

    // }}}
    // {{{ commit()

    /**
    * Rolls back a PDO transaction and handles any exceptions
    *
    * @return bool success - TRUE on success or FALSE on failure
    * @author John Layt
    * @since 2.0
    */
    function rollback()
    {
        $result = FALSE;
        try {
            $result = $this->_pdo->rollBack();
        } catch (PDOException $ex) {
            $this->_lastException = $ex;
            $result = FALSE;
        }
        return $result;
    }

    // }}}
    // {{{ prepare()

    /**
    * Prepares a PDO sql statement and handles any exceptions
    *
    * @param string $sql - an sql statement to prepare for use with PDO 
    * @param string $func - the calling function name (to be used in any error messages)
    * @return object $sql - the resulting PDOStatement object
    * @author Stuart Eve
    * @since 2.0
    */
    function prepare($sql, $func)
    {
        try {
            $stmt = $this->_pdo->prepare($sql);
        } catch(PDOException $ex) {
            $this->_lastException = $ex;
            // make up error string
            $err = "Error in query $func";
            $this->_showError($ex->getMessage(), $err);
        }
        if (!isset($stmt)){
            // for debuggery
            echo '<pre>';
            print_r(array('sql'=>$sql,'func'=>$func));
            echo '</pre>';
            return FALSE;
        }
        return $stmt;
    }

    // }}}
    // {{{ execute()

    /**
     * Executes a PDOStatement and handles any exceptions
     *
     * @param object $sql - a properly prepared PDOStatement object (made using prepare())
     * @param array $params - an array that contains the parameters for the query
     * @param string $func - the function name (to be used in any error messages)
     * @return object $sql - the resulting PDOStatement object
     * @author Stuart Eve
     * @since 2.0
     */
    function execute($stmt, $params, $func)
    {
        try {
            $stmt->execute($params);
        } catch(PDOException $ex) {
            $this->_lastException = $ex;
            // make up error string
            $err = "Error in query $func";
            $this->_showError($ex->getMessage(), $err);
        }
        return $stmt;
    }

    // }}}
    // {{{ lastInsertId()

    /**
    * Returns the ID of the last row inserted.
    *
    * Note that calling this after calling commit will always return "0".
    *
    * @return string id - The last row ID
    * @author John Layt
    * @since 2.0
    */
    function lastInsertId()
    {
        $result = "0";
        try {
            $result = $this->_pdo->lastInsertId();
        } catch (PDOException $ex) {
            $this->_lastException = $ex;
            $result = "0";
        }
        return $result;
    }

    // }}}
    // {{{ _showError()

    /**
     * This function catches a PDO exception and deals with it appropriately
     *
     * @param string $ex->getMessage()
     * @param string $err OPTIONAL - any extra error messaging that may be useful
     * @author Stuart Eve
     * @since 2.0
     */
    private function _showError($ex, $err = "")
    {
        //TODO Log to file or db, printing SQL to screen is probably insecure!
        echo "An Error occurred!"; //user friendly message;
        echo "$err $ex";
    }

    // }}} _showError()
    // {{{ dbTimestamp()

    /**
     * Returns the db timestamp
     *
     * @param string $timestamp  The timestamp, NOW(), or blank
     * @return string $timestamp  The timestamp
     * @author John Layt
     * @since 2.0
     */
    function timestamp($timestamp = NULL)
    {
        if (!$timestamp || $timestamp == "NOW()") {
            return gmdate("Y-m-d H:i:s", time());
        }
        return $timestamp;
    }
    // }}}
    // {{{ insert()

    /**
     * Runs an insert query, logs if requested, and returns a result array
     *
     * @param string $table The table to insert into
     * @param array $fields The fields to insert
     * @param array $values The values to set the fields to
     * @param string $logtype  The query type to log
     * @param string $log_by  The author of the query
     * @param string $log_on  The timestamp of the query
     * @param string $function  The function name (to be used in any error messages)
     * @return array $result  An array containing results info
     * @author John Layt
     * @since 2.0
     */
    function insert($table, $fields, $values, $logtype, $log_by, $log_on, $function)
    {
        global $log_ins;
        // Create the sql
        $fl = implode(', ', $fields);
        if (count($fields) > 0) {
            $vl = str_repeat('?, ', count($fields) - 1).'?';
        } else {
            $vl = '';
        }
        $sql = "
            INSERT INTO $table ($fl)
            VALUES ($vl)
        ";
        // Execute the query
        $stmt = $this->prepare($sql, $function);
        $stmt = $this->execute($stmt, $values, $function);
        // Prepare the results
        if ($stmt->errorCode() == '00000') {
            $results['new_id'] = $this->_pdo->lastInsertId();
            $results['success'] = TRUE;
            $results['sql'] = $stmt;
        } else {
            $results['new_id'] = FALSE;
            $results['success'] = FALSE;
            $results['sql'] = $stmt;
        }
        if ($log_ins) {
            $logvars = 'The sql: '. json_encode($stmt);
            logEvent($logtype, $logvars, $log_by, $log_on);
        }
        return ($results);
    }

    // }}}
    // {{{ update()

    /**
     * Runs a DB Update query for a single row on an ID-keyed table,
     * logs the query if required, and returns a result array
     *
     * @param string $table The table to update
     * @param string $key The key field of the row to update
     * @param string $id The id key of the row to update
     * @param array $fields The fields to update
     * @param array $values The values to update the fields to
     * @param string $logtype  The query type to log
     * @param string $log_by  The author of the query
     * @param string $log_on  The timestamp of the query
     * @param string $function  The function name (to be used in any error messages)
     * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
     * @author John Layt
     * @since 2.0
     */

    function update($table, $key, $id, $fields, $values, $logtype, $log_by, $log_on, $function)
    {
        global $log_upd;
        $set = implode(' = ?,', $fields).' = ?';
        $sql = "
            UPDATE $table
            SET $set
            WHERE $key = $id
        ";
        // log the old entry
        if ($log_upd) {
            $logvars = getRow($table, FALSE, "WHERE $key = $id");
            $log_ref = $table;
            $log_refid = $logvars['id'];
        }
        // run query
        $stmt = $this->prepare($sql, $function);
        $stmt = $this->execute($stmt, $values, $function);
        $rows = $stmt->rowCount();
        if ($rows > 0) {
            $results['success'] = TRUE;
            $results['rows'] = $rows;
            $results['sql'] = $stmt;
        } else {
            $results['success'] = FALSE;
            $results['rows'] = 0;
            $results['sql'] = $stmt;
        }
        if ($log_upd) {
            logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
        }
        return ($results);
    }

    // }}}
    // {{{ get()

    /**
     * Runs a DB Select query and returns a result array
     *
     * @param string $sql The sql to execute
     * @param array $values The values to use in the sql
     * @param string $function  The function name (to be used in any error messages)
     * @return array $results containing selcted rows or FALSE
     * @author John Layt
     * @since 2.0
     */

    function get($sql, $values, $function)
    {
        // run query
        $stmt = $this->prepare($sql, $function);
        $stmt = $this->execute($stmt, $values, $function);
        // Handle results
        $results = array();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            do {
                $results[] = $row;
            } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
            return $results;
        }
        return $results;
    }

    // }}}
    // {{{ getRow()

    /**
     * Runs a database select query for a single matching row on a single table.
     *
     * @param string $table The table to update
     * @param array $fields The key fields to select
     * @param array $values The key values to select
     * @param string $function  The function name (to be used in any error messages)
     * @return array $results An array of the row, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */

    function getRow($table, $fields, $values, $function)
    {
        if (count($fields)) {
            $where = implode(' = ? AND ', $fields).' = ?';
            $sql = "
                SELECT *
                FROM $table
                WHERE $where
            ";
        } else {
            $sql = "
                SELECT *
                FROM $table
            ";
        }
        // run query
        $stmt = $this->prepare($sql, $function);
        $stmt = $this->execute($stmt, $values, $function);
        if ($stmt->errorCode() == '00000' and $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
        return array();
    }

    // }}}
    // {{{ getRows()

    /**
     * Runs a database select query for all matching rows in a table.
     *
     * @param string $table The table to query
     * @param array $fields The key fields to select
     * @param array $values The key values to select
     * @param string $function  The function name (to be used in any error messages)
     * @return array $results An array of the rows, empty if no matching rows found
     * @author John Layt
     * @since 2.0
     */

    function getRows($table, $fields, $values, $function)
    {
        $where = implode(' = ? AND ', $fields).' = ?';
        $sql = "
            SELECT *
            FROM $table
            WHERE $where
        ";
        // run query
        $stmt = $this->prepare($sql, $function);
        $stmt = $this->execute($stmt, $values, $function);
        $results = array();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            do {
                $results[] = $row;
            } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
            return $results;
        }
        return $results;
    }

    // }}}
    // {{{ clear()

    /**
     * Clears a database table
     *
     * @param string $table The table to clear
     * @return boolean $result Returns TRUE if the table was cleared, or FALSE if the query failed
     * @author John Layt
     * @since 2.0
     */
    function clear($table)
    {
        $sql = "TRUNCATE $table";
        $stmt = $this->prepare($sql, 'ADO::clear');
        $stmt = $this->execute($stmt, array(), 'ADO::clear');
        return ($stmt->errorCode() == '00000');
    }

    // }}}
    // {{{ elementConfig()

    /**
     * Returns a Config Element.
     *
     * @param string $element_id The element to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function elementConfig($element_id, $function = __METHOD__)
    {
        $sql = "
            SELECT cor_conf_element.*, cor_conf_element_type.conf_table, cor_conf_element_type.conf_key
            FROM cor_conf_element
            LEFT JOIN cor_conf_element_type
            ON cor_conf_element.element_type = cor_conf_element_type.element_type
            WHERE cor_conf_element.element_id = ?
        ";
        $rows = $this->get($sql, array($element_id), $function);
        if (count($rows)) {
            return $rows[0];
        }
        return array();
    }

    // }}}
    // {{{ fieldConfig()

    /**
     * Returns a Field Config.
     *
     * @param string $field_id The field to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function fieldConfig($field_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_field', array('field_id'), array($field_id), $function);
    }

    // }}}
    // {{{ linkConfig()

    /**
     * Returns a Link Config.
     *
     * @param string $link_id The link to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function linkConfig($link_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_link', array('link_id'), array($link_id), $function);
    }

    // }}}
    // {{{ subformConfig()

    /**
     * Returns a Subform Config.
     *
     * @param string $subform_id The subform to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function subformConfig($subform_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_subform', array('subform_id'), array($subform_id), $function);
    }

    // }}}
    // {{{ elementGroup()

    /**
     * Returns a Config Group for an Element.
     *
     * @param string $parent_id The parent element to retrieve the group for.
     * @param string $child_type The child element type to retrieve (optional)
     * @param string $enabled The enabled status to retrieve, TRUE, FALSE, or NULL for all (optional)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function elementGroup($parent_id, $child_type = NULL, $enabled = TRUE, $function = __METHOD__)
    {
        $where = 'cor_conf_group.element_id = ?';
        $values[] = $parent_id;
        if ($child_type) {
            $where .= ' AND cor_conf_element.element_type = ?';
            $values[] = $child_type;
        }
        if ($enabled != NULL) {
            $where .= ' AND cor_conf_group.enabled = ?';
            $values[] = $enabled;
        }
        $sql = "
            SELECT cor_conf_group.*, cor_conf_element.element_type AS child_type
            FROM cor_conf_group
            INNER JOIN cor_conf_element
            ON cor_conf_group.child_id = cor_conf_element.element_id
            WHERE $where
        ";
        return $this->get($sql, $values, $function);
    }

    // }}}
    // {{{ elementAlias()

    /**
     * Returns the Alias Config for a Config Element.
     *
     * @param string $element_id The element to retrieve the alias for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function elementAlias($element_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_alias', array('element_id'), array($element_id), $function);
    }

    // }}}
    // {{{ elementOption()

    /**
     * Returns an Option for an Element.
     *
     * @param string $element_id The element to retrieve the option for
     * @param string $option_id The option to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function elementOption($element_id, $option_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_option', array('element_id', 'option_id'), array($element_id, $option_id), __METHOD__);
    }

    // }}}
    // {{{ elementConditions()

    /**
     * Returns all the Options that apply to an Element.
     *
     * @param string $element_id The element to retrieve the options for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the matching rows, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function elementOptions($element_id, $function = __METHOD__)
    {
        return $this->getRows('cor_conf_option', array('element_id'), array($element_id), $function);
    }

    // }}}
    // {{{ elementConditions()

    /**
     * Returns all the Conditions that apply to a Config Element.
     *
     * @param string $element_id The element to retrieve the conditions for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the matching rows, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function elementConditions($element_id, $function = __METHOD__)
    {
        return $this->getRows('cor_conf_condition', array('element_id'), array($element_id), $function);
    }

    // }}}
    // {{{ validationRule()

    /**
     * Returns the Config for a Validation Rule.
     *
     * @param string $vld_rule_id The element to retrieve the alias for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function validationRule($vld_rule_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_vld_rule', array('vld_rule_id'), array($vld_rule_id), $function);
    }

    // }}}
    // {{{ validationGroup()

    /**
     * Returns all the Validation Rules in a Validation Group.
     *
     * @param string $vld_group_id The group to retrieve the rules for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the matching rows, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function validationGroup($vld_group_id, $function = __METHOD__)
    {
        $rows = $this->getRows('cor_conf_vld_group', array('vld_group_id'), array($vld_group_id), __METHOD__);
        $rules = array();
        foreach ($rows as $row) {
            $rules[] = $this->validationRule($row['vld_rule_id'], $function);
        }
        return $rules;
    }

    // }}}
    // {{{ validationRole()

    /**
     * Returns all the Validation Rules for an element for a validation role.
     *
     * @param string $element_id The element to retrieve the validation rules for
     * @param string $vld_role The validation role to retrieve the validation rules for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the matching rows, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function validationRole($element_id, $vld_role, $function = __METHOD__)
    {
        $row = $this->getRow('cor_conf_element_vld', array('element_id', 'vld_role'), array($element_id, $vld_role), __METHOD__);
        if (count($row)) {
            return $this->validationGroup($row['vld_group_id'], $function);
        }
        return array();
    }

    // }}}
    // {{{ validationRoles()

    /**
     * Returns all the Validation Roles and Rules for an Element.
     *
     * @param string $element_id The element to retrieve the validation rules for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the roles each with an array of rules, empty if no matching rules found
     * @author John Layt
     * @since 2.0
     */
    function validationRoles($element_id, $function = __METHOD__)
    {
        $rows = $this->getRows('cor_conf_element_vld', array('element_id'), array($element_id), __METHOD__);
        $roles = array();
        foreach ($rows as $row) {
            $roles[$row['vld_role']] = $this->validationGroup($row['vld_group_id'], $function);
        }
        return $roles;
    }

    // }}}
    // {{{ pageConfig()

    /**
     * Returns a Page Config.
     *
     * @param string $page_id The page to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function pageConfig($page_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_page', array('page_id'), array($page_id), $function);
    }

    // }}}
    // {{{ moduleConfig()

    /**
     * Returns a Module Config.
     *
     * @param string $module_id The module to retrieve
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function moduleConfig($module_id, $function = __METHOD__)
    {
        return $this->getRow('cor_conf_module', array('module_id'), array($module_id), $function);
    }

    // }}}
    // {{{ pageLayout()

    /**
     * Returns a Page Layout.
     *
     * @param string $page_id The page to retrieve the layout for
     * @param string $module_id The module to retrieve the layout for
     * @param string $layout_role The layout role to retrieve the layout for
     * @param string $function  The calling function name (to be used in any error messages)
     * @return array $results An array of the fields, empty if no matching row found
     * @author John Layt
     * @since 2.0
     */
    function pageLayout($page_id, $module_id, $layout_role, $function = __METHOD__)
    {
        $row = $this->getRow('cor_conf_page_layout', array('page_id', 'module_id', 'layout_role'), array($page_id, $module_id, $layout_role), $function);
        // If no row found for the module_id, try find a common layout to use
        if (!count($row)) {
            $row = $this->getRow('cor_conf_page_layout', array('page_id', 'module_id', 'layout_role'), array($page_id, '', $layout_role), $function);
        }
        return $row;
    }

    // }}}
}
?>
