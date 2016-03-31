<?php

namespace ClearSale\XmlEntity;

trait FormatTrait
{
    public function getFormattedDate($date = null, $isUnixTimestampFormat = false, $format = Order::DATE_TIME_FORMAT)
    {
        if (is_null($date)) {
            return null;
        }

        if (!$isUnixTimestampFormat) {
            $datetime = new DateTime($date);
        } else {
            $datetime = new DateTime();
            $datetime->setTimestamp($date);
        }

        return $datetime->format($format);
    }
}
