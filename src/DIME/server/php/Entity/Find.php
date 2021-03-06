<?php

/**
 * ARK Item Entity.
 *
 * This file is automatically generated as part of ARK, the Archaeological Recording Kit.
 */

namespace DIME\Entity;

use ARK\Model\Item;
use ARK\Model\ItemTrait;

class Find implements Item
{
    use ItemTrait;

    public function __construct(string $schema = 'dime.find')
    {
        $this->construct($schema);
    }
}
