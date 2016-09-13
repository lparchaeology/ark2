<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Link.php
*
* ARK View Link
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Link.php
* @since      2.0
*
*/

namespace ARK\View;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Link extends Element
{
    private $linkType = '';
    private $name = '';
    private $markup = '';
    private $linkTitle = '';
    private $linkClass = '';
    private $imageClass = '';
    private $listClass = '';
    private $lightbox = false;
    private $image = '';
    private $page = '';
    private $reloadPage = '';
    private $query = array();
    private $link = '';

    public function __construct(Database $db, string $link = null)
    {
        if ($link == null) {
            return;
        }
        try {
            parent::__construct($db, $link, 'link');
            $config = $db->getLink($link);
            $this->linkType = $config['type'];
            $this->name = $config['name'];
            $this->markup = $config['markup'];
            $this->linkTitle = $config['title'];
            $this->linkClass = $config['link_class'];
            $this->imageClass = $config['img_class'];
            $this->listClass = $config['list_class'];
            $this->lightbox = $config['lightbox'];
            $this->image = $config['image'];
            $this->page = $config['page'];
            $this->reloadPage = $config['reload_page'];
            $this->query = unserialize($config['query']);
            $this->link = $config['url'];
            $this->valid = true;
        } catch (DBALException $e) {
            return;
        }
    }

    public function linkType()
    {
        return $this->linkType;
    }

    public function name()
    {
        return $this->name;
    }

    public function markup()
    {
        return $this->markup;
    }

    public function linkTitle()
    {
        return $this->linkTitle;
    }

    public function linkClass()
    {
        return $this->linkClass;
    }

    public function imageClass()
    {
        return $this->imageClass;
    }

    public function listClass()
    {
        return $this->listClass;
    }

    public function lightbox()
    {
        return $this->lightbox;
    }

    public function image()
    {
        return $this->image;
    }
    public function page()
    {
        return $this->page;
    }
    public function reloadPage()
    {
        return $this->reloadPage;
    }

    public function query()
    {
        return $this->query;
    }

    public function url()
    {
        return $this->url;
    }

    public function href()
    {
        if ($this->page) {
            $href = $this->page.'.php';
            if ($this->query) {
                $href .= '?';
                $parms = array();
                foreach ($this->query as $key => $value) {
                    if ($value) {
                        $parms[] = $key.'='.$value;
                    } else {
                        $parms[] = $key;
                    }
                }
                $href .= implode('&', $parms);
            }
        } else {
            $href = $this->url;
        }
        return $href;
    }

    public function buildForm(FormBuilder &$formBuilder)
    {
        if (!$this->isValid()) {
            return;
        }
        $formBuilder->add($this->id, UriType::class, array('label' => $this->title));
    }

    public static function fetchLinks(Database $db, $element, bool $enabled = true)
    {
        $children = $db->getGroup($element, 'link', $enabled);
        $links = array();
        foreach ($children as $child) {
            $link = new Link($child['child']);
            if ($link->isValid()) {
                $links[] = $link;
            }
        }
        return $links;
    }
}
