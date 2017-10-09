<?php

/**
 * ARK Item Entity.
 *
 * This file is automatically generated as part of ARK, the Archaeological Recording Kit.
 */

namespace Entity;

use ARK\Model\Item;
use ARK\Model\ItemTrait;

class Project implements Item
{
    use ItemTrait;

    public function __construct(string $schema = 'arch.project')
    {
        $this->construct($schema);
    }
}