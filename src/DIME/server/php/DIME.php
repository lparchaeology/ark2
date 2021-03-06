<?php

/**
 * DIME Globals.
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

namespace DIME;

use ARK\File\File;
use ARK\File\MediaType;
use ARK\Message\Message;
use ARK\Model\Fragment\DateFragment;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Security\Person;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Action;
use DateTime;
use DIME\Entity\Find;
use DIME\Entity\Museum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Exception;

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

    public static function generateTreasureClaimFile(iterable $finds, Museum $museum, Person $claimant, Person $agent) : File
    {
        $data['finds'] = $finds;
        $data['museum'] = $museum;
        $data['claimant'] = $claimant;
        $data['agent'] = $agent;

        $options['page-size'] = 'A4';
        $options['orientation'] = 'Landscape';
        $options['viewport-size'] = '1280x800';
        $pdf = Service::view()->renderPdf('pages/treasure.html.twig', ['data' => $data], $options);

        $mediatype = new MediaType('application/pdf');
        $file = File::createFromContent($mediatype, 'Danefae.pdf', $pdf);
        // TODO This should work but doesn't, object does not rehydrate....
        $file->setName('Danefae'.$file->id().'.pdf');
        return $file;
    }

    public static function getMapTicket() : ?string
    {
        if ($credentials = Service::security()->credentials('kortforsyningen')) {
            $user = $credentials['user'];
            $password = $credentials['password'];
            $path = "https://services.kortforsyningen.dk/service?request=GetTicket&login=$user&password=$password";
            try {
                $ticket = file_get_contents($path);
            } catch (Exception $e) {
                $ticket = null;
            }
            if (mb_strlen($ticket) === 32) {
                return $ticket;
            }
        }
        return null;
    }

    public static function getNotifications(Actor $actor, string $status = 'unread') : Collection
    {
        if ($actor->id() === 'anonymous') {
            return new ArrayCollection();
        }

        $messages = [];

        if ($status === 'unread') {
            $messages = Message::findUnreadBy($actor)->toArray();
            foreach ($actor->agencies() as $agentFor) {
                $messages = array_merge($messages, Message::findUnreadBy($agentFor)->toArray());
            }
        }

        if ($status === 'read') {
            $messages = Message::findReadBy($actor)->toArray();
            foreach ($actor->agencies() as $agentFor) {
                $messages = array_merge($messages, Message::findReadBy($agentFor)->toArray());
            }
        }

        if ($status === 'received' || $status === 'all') {
            $messages = Message::findReceivedBy($actor)->toArray();
            foreach ($actor->agencies() as $agentFor) {
                $messages = array_merge($messages, Message::findReceivedBy($agentFor)->toArray());
            }
        }

        if ($status === 'sent' || $status === 'all') {
            $messages = array_merge($messages, Message::findSentBy($actor)->toArray());
            foreach ($actor->agencies() as $agentFor) {
                $messages = array_merge($messages, Message::findSentBy($agentFor)->toArray());
            }
        }
        krsort($messages);
        return new ArrayCollection(array_values($messages));
    }

    public static function publishFinds(Actor $actor = null) : iterable
    {
        $published = [];
        $actor = $actor ?? Service::workflow()->actor();
        $today = new DateTime();
        $frags = ORM::findBy(DateFragment::class, ['module' => 'find', 'attribute' => 'publish']);
        foreach ($frags as $frag) {
            $publish = $frag->value();
            if ($publish <= $today) {
                $find = $frag->owner();
                $action = Action::find($find->schema()->id(), 'publish');
                $action->apply($actor, $find);
                ORM::persist($find);
                $published[$find->id()] = $publish->format('Y-m-d');
            }
        }
        if ($published) {
            ORM::flush();
        }
        ORM::flush();
        return $published;
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

    public static function getFeaturedFinds(int $limit = null) : Collection
    {
        // Featured Finds must have been through Treasure assessment to ensure quality and have photos
        $items = self::findSearch(['treasure' => ['appraisal', 'treasure', 'not']]);
        // Featured Finds must be public, and the most recent
        $finds = ORM::findBy(Find::class, ['id' => $items, 'visibility' => 'public'], ['id' => 'DESC'], $limit);
        return $finds;
    }

    public static function findSearch(iterable $query) : ?iterable
    {
        $conn = Service::database()->data();
        $types = [
            Connection::PARAM_STR_ARRAY,
        ];
        $results = [];

        // Do the Vocabulary Term queries
        $pre = "
            SELECT item
            FROM ark_fragment_string
            WHERE module = 'find'
        ";
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
        if (isset($query['visibility'])) {
            $sql = $pre."AND attribute = 'visibility' AND value IN (?)";
            $params = [
                $query['visibility'],
            ];
            $results['visibility'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['custody'])) {
            $sql = $pre."AND attribute = 'custody' AND value IN (?)";
            $params = [
                $query['custody'],
            ];
            $results['custody'] = $conn->fetchAllColumn($sql, 'item', $params, $types);
        }

        // Do the Date queries, i.e. Find Date
        $pre = "
            SELECT item
            FROM ark_fragment_date
            WHERE module = 'find'
        ";
        if (isset($query['find_date']) && isset($query['find_date_span'])) {
            $sql = $pre.'AND attribute = ? AND value >= ? AND value <= ?';
            $params = [
                'finddate',
                $query['find_date'],
                $query['find_date_span'],
            ];
            $results['find_date'] = $conn->fetchAllColumn($sql, 'item', $params);
        } elseif (isset($query['find_date'])) {
            $sql = $pre.'AND attribute = ? AND value = ?';
            $params = [
                'finddate',
                $query['find_date'],
            ];
            $results['find_date'] = $conn->fetchAllColumn($sql, 'item', $params);
        }

        // Do the linked Item queries, i.e. Actors
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

        // Merge all the result sets into a single sorted result list
        $all = [];
        foreach ($results as $key => $items) {
            $all = array_merge($all, $items);
        }
        $all = array_unique($all);
        natsort($all);
        $result = call_user_func_array('array_intersect', array_merge([$all], array_values($results)));
        return $result;
    }
}
