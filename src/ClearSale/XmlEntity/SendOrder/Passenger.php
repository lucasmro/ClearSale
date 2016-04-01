<?php

namespace ClearSale\XmlEntity\SendOrder;

use ClearSale\Exception\RequiredFieldException;
use ClearSale\XmlEntity\XmlEntityInterface;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

class Passenger implements XmlEntityInterface
{
    const DOCUMENT_TYPE_CPF            = 1;
    const DOCUMENT_TYPE_CNPJ           = 2;
    const DOCUMENT_TYPE_RG             = 3;
    const DOCUMENT_TYPE_IE             = 4;
    const DOCUMENT_TYPE_PASSAPORTE     = 5;
    const DOCUMENT_TYPE_CTPS           = 6;
    const DOCUMENT_TYPE_TITULO_ELEITOR = 7;

    private $documentTypes = array(
        self::DOCUMENT_TYPE_CPF,
        self::DOCUMENT_TYPE_CNPJ,
        self::DOCUMENT_TYPE_RG,
        self::DOCUMENT_TYPE_IE,
        self::DOCUMENT_TYPE_PASSAPORTE,
        self::DOCUMENT_TYPE_CTPS,
        self::DOCUMENT_TYPE_TITULO_ELEITOR
    );

    private $name;
    private $frequentFlyerCard;
    private $legalDocumentType;
    private $legalDocument;
    private $birthDate;

    public static function create($name, $legalDocumentType, $legalDocument, DateTime $birthDate = null, $frequentFlyerCard = null)
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

    /**
     *
     * @return DateTime
     */
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
        if (!in_array($legalDocumentType, $this->documentTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid document type (%s)', $legalDocumentType));
        }

        $this->legalDocumentType = $legalDocumentType;
        return $this;
    }

    public function setLegalDocument($legalDocument)
    {
        $this->legalDocument = $legalDocument;
        return $this;
    }

    /**
     *
     * @param DateTime $birthDate
     * @return Passenger
     */
    public function setBirthDate(DateTime $birthDate = null)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement('Passenger');

        if ($this->name) {
            $xml->writeElement('Name', $this->name);
        } else {
            throw new RequiredFieldException('Field Date of the Passenger object is required');
        }

        if ($this->frequentFlyerCard) {
            $xml->writeElement('FrequentFlyerCard', $this->frequentFlyerCard);
        }

        if ($this->legalDocumentType) {
            $xml->writeElement('LegalDocumentType', $this->legalDocumentType);
        } else {
            throw new RequiredFieldException('Field LegalDocumentType of the Passenger object is required');
        }

        if ($this->legalDocument) {
            $xml->writeElement('LegalDocument', $this->legalDocument);
        } else {
            throw new RequiredFieldException('Field LegalDocument of the Passenger object is required');
        }

        if ($this->birthDate) {
            $xml->writeElement('BirthDate', $this->birthDate->format(Order::DATE_TIME_FORMAT));
        }

        $xml->endElement();
    }
}
