<?php

namespace ClearSale\Common\DataFixtures;

use ClearSale\XmlEntity\SendOrder\Item;

class ItemFixture
{
    public static function createItem()
    {
        return Item::create(1, 'Adaptador USB', 10.0, 1);
    }
}
