<?php

/**
 * ARK Command Handler
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

namespace ARK\ORM\Command;

use ARK\ARK;
use ARK\ORM\ClassMetadata;
use ARK\ORM\Command\GenerateItemEntityMessage;
use ARK\ORM\ItemEntityMappingDriver;
use ARK\ORM\ItemEntityGenerator;
use ARK\Service;

class GenerateItemEntityHandler
{
    protected static $classTemplate =
'<?php

/**
 * ARK Item Entity
 *
 * This file is automatically generated as part of ARK, the Archaeological Recording Kit.
 */

namespace <namespace>;

use ARK\Model\Item;
use ARK\Model\ItemTrait;

class <entity> implements Item
{
    use ItemTrait;

    protected $type = \'<type>\';

    public function __construct($schema)
    {
        $this->schma = $schema;
    }
}
';

    protected static $subclassTemplate =
'<?php

/**
 * ARK Item Entity
 *
 * This file is automatically generated as part of ARK, the Archaeological Recording Kit.
 */

namespace <namespace>;

use <parent>;

class <entity> extends <extends>
{
    protected $type = \'<type>\';
}
';

    public function __invoke(GenerateItemEntityMessage $message)
    {
        $module = Service::database()->getModuleForClassName($message->classname());
        $class = $this->generateEntityClass($message->namespace(), $module['entity']);
        $this->writeEntityClass($message->project(), $message->classname(), $class);
        $types = Service::database()->getTypeEntities($module['module']);
        // TODO File base type
        foreach ($types as $type) {
            $classname = $type['classname'];
            $pos = strrpos($classname, '\\');
            $namespace = substr($classname, 0, $pos);
            $entity = substr($classname, $pos + 1);
            $subclass = $this->generateEntitySubclass($namespace, $entity, $message->classname(), $module['entity']);
            $this->writeEntityClass($message->project(), $type['classname'], $subclass, $type);
        }
        /*
        TODO Make this work properly!!!
        $generator = new ItemEntityGenerator;
        $metadata = new ClassMetadata($message->classname());
        $driver = new ItemEntityMappingDriver($message->namespace());
        $driver->loadMetadataForGenerator($message->classname(), $metadata);
        $generator->writeEntityClass($metadata, ARK::autoloadDir($message->project()), $message->project());
        */
    }

    private function writeEntityClass($project, $classname, $class)
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
        $path = str_replace($project, ARK::autoloadDir($project), $path).'.php';
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        file_put_contents($path, $class);
        chmod($path, 0664);
    }

    private function generateEntityClass($namespace, $entity, $type = '')
    {
        $body = str_replace('<namespace>', $namespace, self::$classTemplate);
        $body = str_replace('<entity>', $entity, $body);
        $body = str_replace('<type>', $type, $body);
        return $body;
    }

    private function generateEntitySubclass($namespace, $entity, $parent, $extends, $type)
    {
        $body = str_replace('<namespace>', $namespace, self::$subclassTemplate);
        $body = str_replace('<entity>', $entity, $body);
        $body = str_replace('<parent>', $parent, $body);
        $body = str_replace('<extends>', $extends, $body);
        $body = str_replace('<type>', $type, $body);
        return $body;
    }
}
