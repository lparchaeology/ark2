<?php

/**
 * ARK JSON:API Action.
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

namespace ARK\Api\JsonApi\Action;

use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\Database\Database;
use ARK\Framework\Application;
use ARK\Http\Error\BadRequestError;
use ARK\Http\Error\InternalServerError;
use ARK\Model\Item\Item;
use ARK\Model\Module\Module;
use Exception;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Resource;

class ItemPostAction extends AbstractJsonApiAction
{
    use \ARK\Api\JsonApi\JsonSchemaTrait;

    private $site;
    private $module;
    private $item;
    private $index;

    public function __invoke(Application $app, JsonApiRequest $request, $siteSlug = null, $moduleSlug = null, $itemSlug = null)
    {
        $this->data = json_decode($request->getContent(), true)['data'];
        $this->site = $siteSlug;
        $this->module = $moduleSlug;
        $this->item = $itemSlug;
        if ($itemSlug) {
            $this->index = $itemSlug;
            $this->item = $this->site.'.'.$this->index;
        } elseif (!empty($this->data['id'])) {
            $this->index = $this->data['id'];
            $this->item = $this->site.'.'.$this->index;
        }
        return parent::__invoke($app, $request);
    }

    protected function fetchData() : void
    {
        $root = Module::getRoot($this->app['database'], 'ark');
        $this->site = $root->submodule($root->schemaId(), 'ste')->item($this->site);
        $this->module = $this->site->submodule($this->module);
        if (!$this->item) {
            $last = Item::getLast($this->app['database'], $this->module, $this->site);
            $this->index = (int) $last->index() + 1;
            $this->item = $this->site->id().'.'.$this->index;
        }
        $item = $this->module->item($this->item);
        if ($item->isValid()) {
            $this->addError(new BadRequestError('Resource Already Exists', 'The requested new resource '.$item->id().' already exists.'));
            throw new JsonApiException();
        }
    }

    protected function validateParamaters() : void
    {
        if ($this->parameters->hasParameters()) {
            $this->addError(new BadRequestError('Invalid Parameters', 'Post requests should not have parameters.'));
            throw new JsonApiException();
        }
    }

    protected function validateContent() : void
    {
        $data = json_decode($this->request->getContent())->data->attributes;
        $schema = json_decode($this->app['serializer']->serialize($this->module, 'json', ['schemaId' => 'simple']));
        $this->validateJsonDecode($data, $schema, $this->errors);
    }

    protected function performAction() : void
    {
        try {
            $properties = $this->data['attributes'];
            $this->app['database']->data()->beginTransaction();
            $this->insert($this->app['database'], $properties);
            $this->app['database']->data()->commit();
            //$properties['id'] = $this->site;
            //$this->app['database']->runDataTransaction($this->insert(), $properties);
        } catch (Exception $e) {
            $this->app['database']->data()->rollback();
            if ($this->app['debug'] && $e->getMessage()) {
                $this->addError(new InternalServerError('Database Update Failed', $e->getMessage()));
            } else {
                $this->addError(new InternalServerError('Database Update Failed', 'The database insert failed for unknown reasons.'));
            }
            throw new JsonApiException();
        }
        try {
            $root = Module::getRoot($this->app['database'], 'ark');
            $item = $this->module->item($this->item);
            if (!$item->isValid()) {
                throw new Exception();
            }
            $this->data = $item;
        } catch (Exception $e) {
            $this->addError(new InternalServerError('Resource Not Found', 'The requested new resource was created but cannot be found.'));
            throw new JsonApiException();
        }
    }

    protected function createResponse() : void
    {
        $resource = new ItemResource($this->data, $this->parameters, $this->app['serializer']);
        $document = new Document($resource);
        $this->response = new JsonApiResponse($document, 201);
    }

    private function insert(Database $db, array $properties) : void
    {
        $item = (!empty($properties['id']) ? $properties['id'] : $this->site->id().'_'.$this->index);
        unset($properties['id']);
        $modtype = ($properties['modtype'] ?? '');
        unset($properties['modtype']);
        $rowsAdded = $db->addItem($this->module->id(), $this->site->id(), $this->index, $item, $modtype);
        if ($rowsAdded === 0) {
            throw new JsonApiException();
        }
        foreach ($properties as $key => $value) {
            $property = $this->module->property('simple', '', $key);
            if ($property && $property->type() === 'text') {
                foreach ($value as $text) {
                    $db->addPropertyFragments($this->module->id(), $this->item, $key, $property->type(), [['language' => $text[0], 'value' => $text[1]]]);
                }
            } elseif ($property && $property->type() !== 'graph') {
                $value = is_array($value) ? $value : [$value];
                foreach ($value as $val) {
                    $values[] = ['value' => $val];
                }
                $db->addPropertyFragments($this->module->id(), $this->item, $key, $property->type(), $values);
                unset($values);
            }
        }
    }
}
