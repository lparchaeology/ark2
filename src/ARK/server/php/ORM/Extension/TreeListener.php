<?php

/**
 * ARK ORM Tree Listener
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\ORM\Extension;

use ARK\ORM\Extension\ExtensionMetadataFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Tree\TreeListener as GedmoTreeListener;
use ReflectionClass;

class TreeListener extends GedmoTreeListener
{
    private $refl;
    private $emfRefl;
    private $arRefl;
    private $darRefl;

    public function __construct()
    {
        parent::__construct();
        $this->refl = new ReflectionClass('Gedmo\Mapping\MappedEventSubscriber');
        $this->emfRefl = $this->refl->getProperty('extensionMetadataFactory');
        $this->emfRefl->setAccessible(true);
        $this->arRefl = $this->refl->getProperty('annotationReader');
        $this->arRefl->setAccessible(true);
        $this->darRefl = $this->refl->getMethod('getDefaultAnnotationReader');
        $this->darRefl->setAccessible(true);
    }

    public function getExtensionMetadataFactory(ObjectManager $objectManager)
    {
        $extensionMetadataFactory = $this->emfRefl->getValue($this);
        $annotationReader = $this->arRefl->getValue($this);
        $getDefaultAnnotationReader = $this->darRefl;

        $oid = spl_object_hash($objectManager);
        if (!isset($extensionMetadataFactory[$oid])) {
            if (is_null($annotationReader)) {
                // create default annotation reader for extensions
                $annotationReader = $getDefaultAnnotationReader->invoke($this);
                $this->arRefl->setValue($this, $annotationReader);
            }
            $extensionMetadataFactory[$oid] = new ExtensionMetadataFactory(
                $objectManager,
                $this->getNamespace(),
                $annotationReader
            );
            $this->emfRefl->setValue($this, $extensionMetadataFactory);
        }
        return $extensionMetadataFactory[$oid];
    }
}
