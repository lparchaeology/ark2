<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApiResponse.php
*
* JSON:API Response
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApiResponse.php
* @since      2.0
*/

namespace ARK\Api\JsonApi;

class JsonApiParameters
{
    protected $params = null;

    public function __construct(string $path, array $params)
    {
        $this->params = $params;
    }

    public function getInclude(array $available = [])
    {
        if ($include = $this->getInput('include')) {
            $relationships = explode(',', $include);

            $invalid = array_diff($relationships, $available);

            if (count($invalid)) {
                throw new InvalidParameterException(
                    'Invalid includes ['.implode(',', $invalid).']',
                    1,
                    null,
                    'include'
                );
            }

            return $relationships;
        }

        return [];
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

    public function getSort(array $available = [])
    {
        $sort = [];

        if ($input = $this->getInput('sort')) {
            $fields = explode(',', $input);

            foreach ($fields as $field) {
                if (substr($field, 0, 1) === '-') {
                    $field = substr($field, 1);
                    $order = 'desc';
                } else {
                    $order = 'asc';
                }

                $sort[$field] = $order;
            }

            $invalid = array_diff(array_keys($sort), $available);

            if (count($invalid)) {
                throw new InvalidParameterException(
                    'Invalid sort fields ['.implode(',', $invalid).']',
                    3,
                    null,
                    'sort'
                );
            }
        }

        return $sort;
    }

    public function getFields()
    {
        $fields = $this->getInput('fields');

        if (! is_array($fields)) {
            return [];
        }

        return array_map(function ($fields) {
            return explode(',', $fields);
        }, $fields);
    }

    public function getFilter()
    {
        return $this->getInput('filter');
    }

    protected function getInput($key, $default = null)
    {
        return isset($this->input[$key]) ? $this->input[$key] : $default;
    }

    protected function getPage($key)
    {
        $page = $this->getInput('page');

        return isset($page[$key]) ? $page[$key] : '';
    }
}

    protected $includedFields;
    protected $includedRelationships;
    protected $sorting;
    protected $pagination;
    protected $filtering;

    protected function setIncludedFields()
    {
        $this->includedFields = [];
        $fields = $this->getQueryParam("fields", []);
        if (is_array($fields) === false) {
            return;
        }

        foreach ($fields as $resourceType => $resourceFields) {
            if (is_string($resourceFields)) {
                $this->includedFields[$resourceType] = array_flip(explode(",", $resourceFields));
            }
        }
    }

    public function getIncludedFields($resourceType)
    {
        if ($this->includedFields === null) {
            $this->setIncludedFields();
        }

        return isset($this->includedFields[$resourceType]) ? array_keys($this->includedFields[$resourceType]) : [];
    }

    public function isIncludedField($resourceType, $field)
    {
        if ($this->includedFields === null) {
            $this->setIncludedFields();
        }

        if (array_key_exists($resourceType, $this->includedFields) === false) {
            return true;
        }

        if (empty($this->includedFields[$resourceType]) === true) {
            return false;
        }

        return isset($this->includedFields[$resourceType][$field]);
    }

    protected function setIncludedRelationships()
    {
        $this->includedRelationships = [];

        $includeQueryParam = $this->getQueryParam("include", "");
        if ($includeQueryParam === "") {
            return;
        }

        $relationshipNames = explode(",", $includeQueryParam);
        foreach ($relationshipNames as $relationship) {
            $relationship = ".$relationship.";
            $length = strlen($relationship);
            $dot1 = 0;

            while ($dot1 < $length - 1) {
                $dot2 = strpos($relationship, ".", $dot1 + 1);
                $path = substr($relationship, 1, $dot1 > 0 ? $dot1 - 1 : 0);
                $name = substr($relationship, $dot1 + 1, $dot2 - $dot1 - 1);

                if (isset($this->includedRelationships[$path]) === false) {
                    $this->includedRelationships[$path] = [];
                }
                $this->includedRelationships[$path][$name] = $name;

                $dot1 = $dot2;
            };
        }
    }

    public function hasIncludedRelationships()
    {
        if ($this->includedRelationships === null) {
            $this->setIncludedRelationships();
        }

        return empty($this->includedRelationships) === false;
    }

    public function getIncludedRelationships($baseRelationshipPath)
    {
        if ($this->includedRelationships === null) {
            $this->setIncludedRelationships();
        }

        if (isset($this->includedRelationships[$baseRelationshipPath])) {
            return array_values($this->includedRelationships[$baseRelationshipPath]);
        } else {
            return [];
        }
    }

    public function isIncludedRelationship($baseRelationshipPath, $relationshipName, array $defaultRelationships)
    {
        if ($this->includedRelationships === null) {
            $this->setIncludedRelationships();
        }

        if ($this->getQueryParam("include") === "") {
            return false;
        }

        if (empty($this->includedRelationships) && array_key_exists($relationshipName, $defaultRelationships)) {
            return true;
        }

        return isset($this->includedRelationships[$baseRelationshipPath][$relationshipName]);
    }

    protected function setSorting()
    {
        $sortingQueryParam = $this->getQueryParam("sort", "");
        if ($sortingQueryParam === "") {
            $this->sorting = [];
            return;
        }

        $sorting = explode(",", $sortingQueryParam);
        $this->sorting = is_array($sorting) ? $sorting : [];
    }

    public function getSorting()
    {
        if ($this->sorting === null) {
            $this->setSorting();
        }

        return $this->sorting;
    }

    protected function setPagination()
    {
        $pagination =  $this->getQueryParam("page", null);
        $this->pagination = is_array($pagination) ? $pagination : [];
    }

    public function getPagination()
    {
        if ($this->pagination === null) {
            $this->setPagination();
        }

        return $this->pagination;
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

    protected function setFiltering()
    {
        $filtering = $this->getQueryParam("filter", []);
        $this->filtering = is_array($filtering) ? $filtering : [];
    }

    public function getFiltering()
    {
        if ($this->filtering === null) {
            $this->setFiltering();
        }

        return $this->filtering;
    }

    public function getFilteringParam($param, $default = null)
    {
        $filtering = $this->getFiltering();

        return isset($filtering[$param]) ? $filtering[$param] : $default;
    }

    public function getQueryParam($name, $default = null)
    {
        $queryParams = $this->serverRequest->getQueryParams();

        return isset($queryParams[$name]) ? $queryParams[$name] : $default;
    }

    public function withQueryParam($name, $value)
    {
        $self = clone $this;
        $queryParams = $this->serverRequest->getQueryParams();
        $queryParams[$name] = $value;
        $self->serverRequest = $this->serverRequest->withQueryParams($queryParams);
        $self->initializeParsedQueryParams();
        return $self;
    }

    protected function initializeParsedQueryParams()
    {
        $this->includedFields = null;
        $this->includedRelationships = null;
        $this->sorting = null;
        $this->pagination = null;
        $this->filtering = null;
    }

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
