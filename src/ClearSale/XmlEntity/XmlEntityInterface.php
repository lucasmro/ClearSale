<?php

namespace ClearSale\XmlEntity;

use XMLWriter;

interface XmlEntityInterface
{
    public function toXML(XMLWriter $xml);
}
