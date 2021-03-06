<?php

/**
 * ARK Table View.
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

namespace ARK\View;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class Table extends Element
{
    use GridTrait;

    protected $caption;
    protected $header;
    protected $footer;
    protected $sortable;
    protected $searchable;
    protected $list;
    protected $detail;
    protected $expand;
    protected $card;
    protected $thumb;
    protected $view;
    protected $image;
    protected $export;
    protected $columns;
    protected $refresh;
    protected $pagination;
    protected $selection;
    protected $classes;
    protected $url;

    public function showCaption() : bool
    {
        return $this->caption;
    }

    public function showHeader() : bool
    {
        return $this->header;
    }

    public function showFooter() : bool
    {
        return $this->footer;
    }

    public function isSearchable() : bool
    {
        return $this->searchable;
    }

    public function isSortable() : bool
    {
        return $this->sortable;
    }

    public function canExportData() : bool
    {
        return $this->export;
    }

    public function canChooseColumns() : bool
    {
        return $this->columns;
    }

    public function canRefresh() : bool
    {
        return $this->refresh ?? false;
    }

    public function canToggleView() : bool
    {
        return ($this->list + $this->card + $this->thumb) > 1;
    }

    public function enableListView() : bool
    {
        return $this->list;
    }

    public function enableDetailView() : bool
    {
        return $this->detail;
    }

    public function enableExpandListView() : bool
    {
        return $this->list && $this->detail && $this->expand;
    }

    public function enableCardView() : bool
    {
        return $this->card;
    }

    public function enableThumbnailView() : bool
    {
        return $this->thumb;
    }

    public function defaultView() : string
    {
        return $this->view ?? 'list';
    }

    public function selection() : string
    {
        return $this->selection ?? '';
    }

    public function image() : string
    {
        return $this->image ?? '';
    }

    public function classes() : string
    {
        return $this->classes ?? '';
    }

    public function dataUrl() : string
    {
        return $this->url ?? '';
    }

    public function pagination() : bool
    {
        return $this->pagination > 0;
    }

    public function pageSize() : int
    {
        // TODO Get default from config file
        return $this->pagination ?? 10;
    }

    public function pageList() : iterable
    {
        if ($this->pagination === null) {
            return [];
        }
        return [$this->pagination, $this->pagination * 2, $this->pagination * 5, $this->pagination * 10];
    }

    public function buildForms(iterable $view) : iterable
    {
        //dump('TABLE FORMS : '.$this->id());
        //dump($view);
        if ($view['state']['mode'] === 'deny') {
            return [];
        }
        $forms = [];
        foreach ($view['children'] as $child) {
            $forms = array_merge($forms, $child['element']->buildForms($child));
        }
        //dump($forms);
        return $forms;
    }

    public function buildForm(iterable $view, FormBuilderInterface $builder) : void
    {
        //dump('TABLE FORM : '.$this->id());
        //dump($view);
        if ($view['state']['mode'] === 'deny') {
            return;
        }
        foreach ($view['children'] as $child) {
            $child['element']->buildForm($child, $builder);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_table');
        $builder->setReadOnly();

        // Fields
        $builder->addStringField('name', 30);
        $builder->addStringField('mode', 10);
        $builder->addField('caption', 'boolean');
        $builder->addField('header', 'boolean');
        $builder->addField('footer', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addField('searchable', 'boolean');
        $builder->addField('list', 'boolean');
        $builder->addField('detail', 'boolean');
        $builder->addField('expand', 'boolean');
        $builder->addField('card', 'boolean');
        $builder->addField('thumb', 'boolean');
        $builder->addStringField('view', 10);
        $builder->addStringField('image', 30);
        $builder->addField('export', 'boolean');
        $builder->addField('columns', 'boolean');
        $builder->addField('pagination', 'integer');
        $builder->addStringField('selection', 10);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('classes', 100);
        $builder->addStringField('template', 100);
        $builder->addStringField('url', 2038);

        // Associations
        $builder->addOneToManyField('cells', Cell::class, 'group');
    }

    protected function buildChildren(iterable $view) : iterable
    {
        $children = [];
        foreach ($this->cells as $cell) {
            $cellView = $cell->buildView($view);
            if ($cellView) {
                $children[] = $cellView;
            }
        }
        return $children;
    }
}
