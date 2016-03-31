<?php

namespace ClearSale\XmlEntity;

interface XmlEntityInterface
{
    public function toXML(XMLWriter $xml);
}
