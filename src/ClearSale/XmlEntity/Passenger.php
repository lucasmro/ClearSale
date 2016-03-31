<?php

namespace ClearSale\XmlEntity;

use DateTime;
use XMLWriter;

class Passenger implements XmlEntityInterface
{
    use FormatTrait;

    private $name;
    private $frequentFlyerCard;
    private $legalDocumentType;
    private $legalDocument;
    private $birthDate;

    public static function create($name, $legalDocumentType, $legalDocument, $frequentFlyerCard = null,
        $birthDate = null)
    {
        $passenger = new self();
        $passenger
            ->setName($name)
            ->setLegalDocumentType($legalDocumentType)
            ->setLegalDocument($legalDocument)
            ->setFrequentFlyerCard($frequentFlyerCard)
            ->setBirthDate($birthDate);

        return $passenger;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFrequentFlyerCard()
    {
        return $this->frequentFlyerCard;
    }

    public function getLegalDocumentType()
    {
        return $this->legalDocumentType;
    }

    public function getLegalDocument()
    {
        return $this->legalDocument;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setFrequentFlyerCard($frequentFlyerCard)
    {
        $this->frequentFlyerCard = $frequentFlyerCard;
        return $this;
    }

    public function setLegalDocumentType($legalDocumentType)
    {
        $this->legalDocumentType = $legalDocumentType;
        return $this;
    }

    public function setLegalDocument($legalDocument)
    {
        $this->legalDocument = $legalDocument;
        return $this;
    }

    public function setBirthDate($birthDate = null, $isUnixTimestampFormat = false)
    {
        $this->birthDate = $this->getFormattedDate($birthDate, $isUnixTimestampFormat);

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('Passenger');

        if ($this->name) {
            $xml->writeElement('Name', $this->name);
        }

        if ($this->frequentFlyerCard) {
            $xml->writeElement('FrequentFlyerCard', $this->frequentFlyerCard);
        }

        if ($this->legalDocumentType) {
            $xml->writeElement('LegalDocumentType', $this->legalDocumentType);
        }

        if ($this->legalDocument) {
            $xml->writeElement('LegalDocument', $this->legalDocument);
        }

        if ($this->birthDate) {
            $xml->writeElement('BirthDate', $this->birthDate);
        }

        $xml->endElement();
    }
}
