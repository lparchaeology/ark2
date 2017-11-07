<?php

/**
 * DIME Globals.
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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME;

use ARK\Actor\Actor;
use ARK\Actor\Museum;
use ARK\Message\Notification;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;

class DIME
{
    public static function version() : string
    {
        return '0.1.00';
    }

    public static function generateDetectoristId() : string
    {
        $seq = Service::database()->sequence()->generateSequence('DIME', '', 'detectorist_id');
        return 'DB'.str_pad($seq, 6, '0', STR_PAD_LEFT);
    }

    public static function getMapTicket() : ?string
    {
        if ($credentials = Service::security()->credentials('kortforsyningen')) {
            $user = $credentials['user'];
            $password = $credentials['password'];
            $path = "http://services.kortforsyningen.dk/service?request=GetTicket&login=$user&password=$password";
            $ticket = file_get_contents($path);
            if (strlen($ticket) === 32) {
                return $ticket;
            }
        }
        return null;
    }

    public static function getNotifications(Actor $actor = null) : ArrayCollection
    {
        if ($actor === null) {
            $actor = Service::workflow()->actor();
        }
        if ($actor === null || $actor->id() === 'anonymous') {
            return new ArrayCollection();
        }
        $msgIds = Service::database()->getActorMessages($actor->id());
        foreach ($actor->roles() as $role) {
            $msgIds = array_merge($msgIds, Service::database()->getRoleMessages($role->role()->id()));
            if ($role->isAgent()) {
                $msgIds = array_merge($msgIds, Service::database()->getActorMessages($role->agentFor()->id()));
            }
        }
        return ORM::findBy(Notification::class, ['id' => $msgIds], ['created' => 'DESC']);
    }

    public static function getUnreadNotifications(Actor $actor = null) : ArrayCollection
    {
        if ($actor === null) {
            $actor = Service::workflow()->actor();
        }
        $messages = self::getNotifications($actor);
        $unread = new ArrayCollection();
        foreach ($messages as $message) {
            if (!$message->wasReadBy($actor)) {
                $unread[] = $message;
            }
        }
        return $unread;
    }

    public static function findMunicipality(string $wkt) : ?Term
    {
        $mid = Service::database()->getSpatialTermsContain('dime.denmark.municipality', $wkt, '4326');
        if ($mid) {
            return self::getMunicipality($mid[0]['term']);
        }
        return null;
    }

    public static function getMunicipality(string $municipality) : ?Term
    {
        return Vocabulary::findTerm('dime.denmark.municipality', $municipality);
    }

    public static function getMunicipalityMuseum(string $municipality) : ?Museum
    {
        $sql = '
            SELECT item
            FROM ark_fragment_string
            WHERE module = :module
            AND parameter = :parameter
            AND value = :value
        ';
        $params = [
            ':module' => 'actor',
            ':parameter' => 'dime.denmark.municipality',
            ':value' => $municipality,
        ];
        $ids = Service::database()->data()->fetchAll($sql, $params);
        if (isset($ids[0]['item'])) {
            return ORM::find(Museum::class, $ids[0]['item']);
        }
        return null;
    }

    public static function getActorFinds(string $actor) : ?iterable
    {
        $sql = "
            SELECT DISTINCT item
            FROM ark_fragment_item
            WHERE module = 'find'
            AND attribute = 'finder'
            AND value = :actor
        ";
        $params = [
            ':actor' => $actor,
        ];

        return Service::database()->data()->fetchAllColumn($sql, 'item', $params);
    }

    public static function getFinders() : ?iterable
    {
        $sql = "
            SELECT DISTINCT value
            FROM ark_fragment_item
            WHERE module = 'find'
            AND attribute = 'finder'
        ";
        return Service::database()->data()->fetchAllColumn($sql, 'value');
    }

    public static function findSearch(iterable $query) : ?iterable
    {
        $conn = Service::database()->data();
        $pre = "
            SELECT item
            FROM ark_fragment_string
            WHERE module = 'find'
        ";
        $types = [
            Connection::PARAM_STR_ARRAY,
        ];
        $results = [];
        if (isset($query['municipality'])) {
            $sql = $pre."AND attribute = 'municipality' AND value IN (?)";
            $params = [
                $query['municipality'],
            ];
            $results['municipality'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['class'])) {
            $sql = $pre."AND attribute = 'class' AND value IN (?)";
            $params = [
                $query['class'],
            ];
            $results['class'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['period'])) {
            $sql = $pre."AND attribute = 'period' AND value IN (?)";
            $params = [
                $query['period'],
            ];
            $results['period'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['material'])) {
            $sql = $pre."AND attribute = 'material' AND value IN (?)";
            $params = [
                $query['material'],
            ];
            $results['material'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['status'])) {
            $sql = $pre."AND attribute = 'process' AND value IN (?)";
            $params = [
                $query['status'],
            ];
            $results['status'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['treasure'])) {
            $sql = $pre."AND attribute = 'treasure' AND value IN (?)";
            $params = [
                $query['treasure'],
            ];
            $results['treasure'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }

        $pre = "
            SELECT item
            FROM ark_fragment_item
            WHERE module = 'find'
        ";
        if (isset($query['museum'])) {
            $sql = $pre."AND attribute = 'museum' AND parameter = 'actor' AND value IN (?)";
            $params = [
                $query['museum'],
            ];
            $results['museum'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['finder'])) {
            $sql = $pre."AND attribute = 'finder' AND parameter = 'actor' AND value IN (?)";
            $params = [
                $query['finder'],
            ];
            $results['finder'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        $all = [];
        foreach ($results as $key => $items) {
            $all = array_merge($all, $items);
        }
        $all = array_unique($all);
        sort($all);
        $result = call_user_func_array('array_intersect', array_merge([$all], array_values($results)));
        return $result;
    }
}
