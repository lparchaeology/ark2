<?php

/**
 * ARK Item Entity
 *
 * This file is automatically generated as part of ARK, the Archaeological Recording Kit.
 */

namespace ARK\File;

use ARK\Model\Item;
use ARK\Model\ItemTrait;

class File implements Item
{
    use ItemTrait;

    protected $type = 'other';

    public function __construct($schema)
    {
        $this->schma = $schema;
    }
}
