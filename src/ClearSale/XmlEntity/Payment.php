<?php

namespace ClearSale\XmlEntity;

use ClearSale\Exception\RequiredFieldException;
use ClearSale\Type\Currency;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

class Payment implements XmlEntityInterface
{
    const CARTAO_CREDITO           = 1;
    const BOLETO_BANCARIO          = 2;
    const DEBITO_BANCARIO          = 3;
    const DEBITO_BANCARIO_DINHEIRO = 4;
    const DEBITO_BANCARIO_CHEQUE   = 5;
    const TRANSFERENCIA_BANCARIA   = 6;
    const SEDEX_A_COBRAR           = 7;
    const CHEQUE                   = 8;
    const DINHEIRO                 = 9;
    const FINANCIAMENTO            = 10;
    const FATURA                   = 11;
    const CUPOM                    = 12;
    const MULTICHEQUE              = 13;
    const OUTROS                   = 14;

    private static $paymentTypes = array(
        self::CARTAO_CREDITO,
        self::BOLETO_BANCARIO,
        self::DEBITO_BANCARIO,
        self::DEBITO_BANCARIO_DINHEIRO,
        self::DEBITO_BANCARIO_CHEQUE,
        self::TRANSFERENCIA_BANCARIA,
        self::SEDEX_A_COBRAR,
        self::CHEQUE,
        self::DINHEIRO,
        self::FINANCIAMENTO,
        self::FATURA,
        self::CUPOM,
        self::MULTICHEQUE,
        self::OUTROS,
    );

    private $type;
    private $sequential;
    private $date;
    private $amount;
    private $qtyInstallments;
    private $interest;
    private $interestValue;
    private $card;
    private $legalDocument;
    private $address;
    private $nsu;
    private $currency;

    public static function create($type, DateTime $date, $amount)
    {
        $instance = new self();

        $instance
            ->setType($type)
            ->setDate($date)
            ->setAmount($amount);

        return $instance;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!array_key_exists($type, self::$paymentTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid payment type (%s)', $type));
        }

        $this->type = $type;

        return $this;
    }

    public function getSequential()
    {
        return $this->sequential;
    }

    public function setSequential($sequential)
    {
        $this->sequential = $sequential;

        return $this;
    }

    /**
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * 
     * @param DateTime $date
     * @return Payment
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getQtyInstallments()
    {
        return $this->qtyInstallments;
    }

    public function setQtyInstallments($qtyInstallments)
    {
        $this->qtyInstallments = $qtyInstallments;

        return $this;
    }

    public function getInterest()
    {
        return $this->interest;
    }

    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    public function getInterestValue()
    {
        return $this->interestValue;
    }

    public function setInterestValue($interestValue)
    {
        $this->interestValue = $interestValue;

        return $this;
    }

    /**
     *
     * @return Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     *
     * @param Card $card
     * @return Payment
     */
    public function setCard(Card $card)
    {
        $this->card = $card;

        return $this;
    }

    public function getLegalDocument()
    {
        return $this->legalDocument;
    }

    public function setLegalDocument($legalDocument)
    {
        $this->legalDocument = $legalDocument;

        return $this;
    }

    /**
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    public function getNsu()
    {
        return $this->nsu;
    }

    public function setNsu($nsu)
    {
        $this->nsu = $nsu;

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency->toValue();

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        $xml->startElement("Payment");

        if ($this->sequential) {
            $xml->writeElement("Sequential", $this->sequential);
        }

        if ($this->date) {
            $xml->writeElement("Date", $this->date->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field Date of the Payment object is required');
        }

        if ($this->amount) {
            $xml->writeElement("Amount", $this->amount);
        } else {
            throw new RequiredFieldException('Field Amount of the Payment object is required');
        }

        if ($this->type) {
            $xml->writeElement("PaymentTypeID", $this->type);
        } else {
            throw new RequiredFieldException('Field PaymentTypeID of the Payment object is required');
        }

        if ($this->qtyInstallments) {
            $xml->writeElement("QtyInstallments", $this->qtyInstallments);
        }

        if ($this->interest) {
            $xml->writeElement("Interest", $this->interest);
        }

        if ($this->interestValue) {
            $xml->writeElement("InterestValue", $this->interestValue);
        }

        if ($this->card) {
            $this->card->toXML($xml);
        }

        if ($this->legalDocument) {
            $xml->writeElement("LegalDocument", $this->legalDocument);
        }

        if ($this->address) {
            $this->address->toXML($xml);
        }

        if ($this->nsu) {
            $xml->writeElement("Nsu", $this->nsu);
        }

        if ($this->currency) {
            $xml->writeElement("Currency", $this->currency);
        }

        $xml->endElement();
    }
}
