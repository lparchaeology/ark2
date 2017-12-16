<?php

/**
 * ARK JSON:API Request Parameters.
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

namespace ARK\Api\JsonApi\Http;

use ARK\Error\ErrorBag;

class JsonApiParameters
{
    protected $paramaters;
    protected $includedRelationships;
    protected $sparseFieldset;
    protected $sortFieldset;
    protected $pagination;
    protected $filters;
    protected $schema;

    public function __construct(/*string*/ $path, array $paramaters)
    {
        $this->path = $path;
        $this->paramaters = $paramaters;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function hasParameters()
    {
        return !empty($this->paramaters);
    }

    public function validateIncludedRelationships(array $availableRelationships, ErrorBag $errors) : void
    {
        $this->parseIncludedRelationships();
        foreach ($this->includedRelationships as $relationship) {
            if (!in_array($relationship, $availableRelationships, true)) {
                $errors->addError(new InvalidIncludedRelationshipError($relationship));
            }
        }
    }

    public function hasIncludedRelationships()
    {
        $this->parseIncludedRelationships();
        return !empty($this->includedRelationships);
    }

    public function isIncludedRelationship($relationship)
    {
        $this->parseIncludedRelationships();
        return in_array($relationship, $this->includedRelationships, true);
    }

    public function getIncludedRelationships()
    {
        $this->parseIncludedRelationships();
        return $this->includedRelationships;
    }

    public function validateSparseFieldset($resource, array $resourceFields, ErrorBag $errors) : void
    {
        $this->parseSparseFieldset();
        foreach ($this->sparseFieldset[$resource] as $field) {
            if (!in_array($field, $resourceFields, true)) {
                $errors->addError(new InvalidSparseFieldsetError($resource, $field, $resourceFields));
            }
        }
    }

    public function hasSparseFieldset($resource)
    {
        $this->parseSparseFieldset();
        return isset($this->sparseFieldset[$resource]);
    }

    public function inSparseFieldset($resource, $field)
    {
        $this->parseSparseFieldset();
        return isset($this->sparseFieldset[$resource]) && isset($this->sparseFieldset[$resource][$field]);
    }

    public function getSparseFieldset($resource)
    {
        $this->parseSparseFieldset();
        return isset($this->sparseFieldset[$resource]) ? array_keys($this->sparseFieldset[$resource]) : [];
    }

    public function validateSortFieldset(array $resourceFields, ErrorBag $errors) : void
    {
        $this->parseSortFieldset();
        foreach ($this->sortFieldset as $field => $order) {
            if (!in_array($field, $resourceFields, true)) {
                $errors->addError(new InvalidSortFieldsetError($field, $resourceFields));
            }
        }
    }

    public function hasSortFieldset()
    {
        $this->parseSortFieldset();
        return isset($this->sortFieldset);
    }

    public function inSortFieldset($field)
    {
        $this->parseSortFieldset();
        return isset($this->sortFieldset[$field]);
    }

    public function getSortFieldset()
    {
        $this->parseSortFieldset();
        return $this->sortFieldset;
    }

    public function getSortOrder($field)
    {
        if ($this->inSortFieldset($field)) {
            return $this->sortFieldset[$field];
        }
        return null;
    }

    public function hasPagination()
    {
        $this->parsePagination();
        return !empty($this->pagination);
    }

    public function getPagination()
    {
        $this->parsePagination();
        return $this->pagination;
    }

    public function hasFilters()
    {
        $this->parseFilters();
        return !empty($this->filters);
    }

    public function getFilters()
    {
        $this->parseFilters();
        return $this->filters;
    }

    public function includeSchema()
    {
        if ($this->schema === null) {
            $param = $this->getParameter('schema');
            $this->schema = ($param === 'true' ? true : false);
        }
        return $this->schema;
    }

    protected function hasParameter($key)
    {
        return isset($this->paramaters[$key]);
    }

    protected function getParameter($key, $default = null)
    {
        return isset($this->paramaters[$key]) ? $this->paramaters[$key] : $default;
    }

    protected function parseIncludedRelationships() : void
    {
        if ($this->includedRelationships !== null) {
            return;
        }
        $this->includedRelationships = [];
        $this->includedRelationshipTypes = [];
        $include = $this->getParameter('include');
        if (!is_string($include)) {
            return;
        }
        $paths = explode(',', $include);
        foreach ($paths as $path) {
            if ($path && is_string($path)) {
                $this->includedRelationship[] = $path;
                $resources = explode('.', $path);
                foreach ($resources as $resource) {
                    if ($included && is_string($included)) {
                        $this->includedRelationshipTypes[] = $resource;
                    }
                }
            }
        }
    }

    protected function parseSparseFieldset() : void
    {
        if ($this->sparseFieldset !== null) {
            return;
        }
        $this->sparseFieldset = [];
        $fields = $this->getParameter('fields');
        if (!is_array($fields)) {
            return;
        }
        foreach ($fields as $resource => $included) {
            if ($included && is_string($included)) {
                $this->sparseFieldset[$resource] = explode(',', $included);
            }
        }
    }

    protected function parseSortFieldset() : void
    {
        if ($this->sortFieldset !== null) {
            return;
        }
        $this->sortFieldset = [];
        $param = $this->getParameter('sort');
        if ($param && is_string($param)) {
            $fields = explode(',', $param);
            foreach ($fields as $field) {
                if (mb_substr($field, 0, 1) === '-') {
                    $field = mb_substr($field, 1);
                    $order = 'desc';
                } else {
                    $order = 'asc';
                }
                $this->sortFieldset[$field] = $order;
            }
        }
    }

    protected function parsePagination() : void
    {
        $pagination = $this->getParameter('page');
        $this->pagination = is_array($pagination) ? $pagination : [];
    }

    protected function parseFilters() : void
    {
        if ($this->filters !== null) {
            return;
        }
        $param = $this->getParameter('filter');
        $this->filters = is_array($param) ? $param : explode(',', $param);
    }
}
/*
    TODO Pagination


        protected function getPage($key)
        {
            $page = $this->getInput('page');
            return isset($page[$key]) ? $page[$key] : '';
        }

        public function getOffset($perPage = null)
        {
            if ($perPage && ($offset = $this->getOffsetFromNumber($perPage))) {
                return $offset;
            }

            $offset = (int) $this->getPage('offset');

            if ($offset < 0) {
                throw new InvalidParameterException('page[offset] must be >=0', 2, null, 'page[offset]');
            }

            return $offset;
        }

        protected function getOffsetFromNumber($perPage)
        {
            $page = (int) $this->getPage('number');

            if ($page <= 1) {
                return 0;
            }

            return ($page - 1) * $perPage;
        }

        public function getLimit($max = null)
        {
            $limit = $this->getPage('limit') ?: $this->getPage('size') ?: null;

            if ($limit && $max) {
                $limit = min($max, $limit);
            }

            return $limit;
        }

    public function getFixedPageBasedPagination($defaultPage = null)
    {
        return FixedPageBasedPagination::fromPaginationQueryParams($this->getPagination(), $defaultPage);
    }

    public function getPageBasedPagination($defaultPage = null, $defaultSize = null)
    {
        return PageBasedPagination::fromPaginationQueryParams($this->getPagination(), $defaultPage, $defaultSize);
    }

    public function getOffsetBasedPagination($defaultOffset = null, $defaultLimit = null)
    {
        return OffsetBasedPagination::fromPaginationQueryParams($this->getPagination(), $defaultOffset, $defaultLimit);
    }

    public function getCursorBasedPagination($defaultCursor = null)
    {
        return CursorBasedPagination::fromPaginationQueryParams($this->getPagination(), $defaultCursor);
    }

    TODO Document Body

    public function getResource($default = null)
    {
        $body = $this->getParsedBody();
        return isset($body["data"])? $body["data"] : $default;
    }

    public function getResourceType($default = null)
    {
        $data = $this->getResource();

        return isset($data["type"]) ? $data["type"] : $default;
    }

    public function getResourceId($default = null)
    {
        $data = $this->getResource();

        return isset($data["id"]) ? $data["id"] : null;
    }

    public function getResourceAttributes()
    {
        $data = $this->getResource();

        return isset($data["attributes"]) ? $data["attributes"] : [];
    }

    public function getResourceAttribute($attribute, $default = null)
    {
        $attributes = $this->getResourceAttributes();

        return isset($attributes[$attribute]) ? $attributes[$attribute] : $default;
    }

    public function getToOneRelationship($relationship)
    {
        $data = $this->getResource();

        //The relationship has to exist in the request and have a data attribute to be valid
        if (isset($data["relationships"][$relationship]) &&
            array_key_exists("data", $data["relationships"][$relationship])
        ) {
            //If the data is null, this request is to clear the relationship, we return an empty relationship
            if ($data["relationships"][$relationship]["data"] === null) {
                return new ToOneRelationship();
            }
            //If the data is set and is not null, we create the relationship with a resource identifier from the request
            return new ToOneRelationship(
                ResourceIdentifier::fromArray($data["relationships"][$relationship]["data"], $this->exceptionFactory)
            );
        }
        return null;
    }

    public function getToManyRelationship($relationship)
    {
        $data = $this->getResource();

        if (isset($data["relationships"][$relationship]["data"]) === false) {
            return null;
        }

        $resourceIdentifiers = [];
        foreach ($data["relationships"][$relationship]["data"] as $item) {
            $resourceIdentifiers[] = ResourceIdentifier::fromArray($item, $this->exceptionFactory);
        }

        return new ToManyRelationship($resourceIdentifiers);
    }
}
*/
