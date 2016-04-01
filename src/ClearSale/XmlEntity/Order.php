<?php

namespace ClearSale\XmlEntity;

use ClearSale\Exception\RequiredFieldException;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

class Order
{
    const DATE_TIME_FORMAT = 'Y-m-d\TH:i:s';
    const ECOMMERCE_B2B    = 'b2b';
    const ECOMMERCE_B2C    = 'b2c';

    private static $ecommerceTypes = array(
        self::ECOMMERCE_B2B,
        self::ECOMMERCE_B2C,
    );

    const STATUS_NOVO      = 0;
    const STATUS_APROVADO  = 9;
    const STATUS_CANCELADO = 41;
    const STATUS_REPROVADO = 45;

    private static $statuses = array(
        self::STATUS_NOVO,
        self::STATUS_APROVADO,
        self::STATUS_CANCELADO,
        self::STATUS_REPROVADO,
    );

    const PRODUCT_A_CLEAR_SALE          = 1;
    const PRODUCT_M_CLEAR_SALE          = 2;
    const PRODUCT_T_CLEAR_SALE          = 3;
    const PRODUCT_TG_CLEAR_SALE         = 4;
    const PRODUCT_TH_CLEAR_SALE         = 5;
    const PRODUCT_TG_LIGHT_CLEAR_SALE   = 6;
    const PRODUCT_TG_FULL_CLEAR_SALE    = 7;
    const PRODUCT_T_MONITORADO          = 8;
    const PRODUCT_SCORE_DE_FRAUDE       = 9;
    const PRODUCT_CLEAR_ID              = 10;
    const PRODUCT_ANALISE_INTERNACIONAL = 11;

    private static $products = array(
        self::PRODUCT_A_CLEAR_SALE,
        self::PRODUCT_M_CLEAR_SALE,
        self::PRODUCT_T_CLEAR_SALE,
        self::PRODUCT_TG_CLEAR_SALE,
        self::PRODUCT_TH_CLEAR_SALE,
        self::PRODUCT_TG_LIGHT_CLEAR_SALE,
        self::PRODUCT_TG_FULL_CLEAR_SALE,
        self::PRODUCT_T_MONITORADO,
        self::PRODUCT_SCORE_DE_FRAUDE,
        self::PRODUCT_CLEAR_ID,
        self::PRODUCT_ANALISE_INTERNACIONAL,
    );

    const LIST_TYPE_NAO_CADASTRADA        = 1;
    const LIST_TYPE_CHA_DE_BEBE           = 2;
    const LIST_TYPE_CASAMENTO             = 3;
    const LIST_TYPE_DESEJOS               = 4;
    const LIST_TYPE_ANIVERSARIO           = 5;
    const LIST_TYPE_CHA_BAR_OU_CHA_PANELA = 6;

    private static $listTypes = array(
        self::LIST_TYPE_NAO_CADASTRADA,
        self::LIST_TYPE_CHA_DE_BEBE,
        self::LIST_TYPE_CASAMENTO,
        self::LIST_TYPE_DESEJOS,
        self::LIST_TYPE_ANIVERSARIO,
        self::LIST_TYPE_CHA_BAR_OU_CHA_PANELA,
    );
    private $fingerPrint;
    private $id;
    private $date;
    private $email;
    private $ecommerceType;
    private $shippingPrice;
    private $totalItems;
    private $totalOrder;
    private $quantityInstallments;
    private $deliveryTime;
    private $quantityItems;
    private $quantityPaymentTypes;
    private $ip;
    private $gift;
    private $giftMessage;
    private $notes;
    private $status;
    private $reanalysis;
    private $origin;
    private $reservationDate;
    private $country;
    private $nationality;
    private $product;
    private $listType;
    private $listId;
    private $billingData;
    private $shippingData;
    private $payments;
    private $items;
    private $passengers;
    private $connections;
    private $hotelReservations;

    /**
     *
     * @param FingerPrint $fingerPrint
     * @param int $id
     * @param DateTime $date
     * @param string $email
     * @param float $totalOrder
     * @param Customer $billingData
     * @param Customer $shippingData
     * @param Payment $payment
     * @param Item $item
     * @param Passenger $passenger
     * @param Connection $connection
     * @param HotelReservation $hotelReservation
     * @return Order
     */
    public static function create(FingerPrint $fingerPrint, $id, DateTime $date, $email, $totalOrder,
        Customer $billingData, Customer $shippingData, Payment $payment, Item $item, Passenger $passenger = null,
        Connection $connection = null, HotelReservation $hotelReservation = null)
    {
        $instance = new self();

        $instance->setFingerPrint($fingerPrint);
        $instance->setId($id);
        $instance->setDate($date);
        $instance->setEmail($email);
        $instance->setTotalItems(1);
        $instance->setTotalOrder($totalOrder);
        $instance->setBillingData($billingData);
        $instance->setShippingData($shippingData);
        $instance->addPayment($payment);
        $instance->addItem($item);

        if (!is_null($passenger)) {
            $instance->addPassenger($passenger);
        }

        if (!is_null($connection)) {
            $instance->addConnection($connection);
        }

        if (!is_null($hotelReservation)) {
            $instance->addHotelReservation($hotelReservation);
        }

        return $instance;
    }

    public function getFingerPrint()
    {
        return $this->fingerPrint;
    }

    public function setFingerPrint(FingerPrint $fingerPrint)
    {
        $this->fingerPrint = $fingerPrint;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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
     * @return Order
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEcommerceType()
    {
        return $this->ecommerceType;
    }

    public function setEcommerceType($ecommerceType)
    {
        if (!array_key_exists($ecommerceType, self::$ecommerceTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid ecommerce type (%s)', $ecommerceType));
        }

        $this->ecommerceType = $ecommerceType;

        return $this;
    }

    public function getShippingPrice()
    {
        return $this->shippingPrice;
    }

    public function setShippingPrice($shippingPrice)
    {
        $this->shippingPrice = $shippingPrice;

        return $this;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }

    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;

        return $this;
    }

    public function getTotalOrder()
    {
        return $this->totalOrder;
    }

    public function setTotalOrder($totalOrder)
    {
        $this->totalOrder = $totalOrder;

        return $this;
    }

    public function getQuantityInstallments()
    {
        return $this->quantityInstallments;
    }

    public function setQuantityInstallments($quantityInstallments)
    {
        $this->quantityInstallments = $quantityInstallments;

        return $this;
    }

    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;

        return $this;
    }

    public function getQuantityItems()
    {
        return $this->quantityItems;
    }

    public function setQuantityItems($quantityItems)
    {
        $this->quantityItems = $quantityItems;

        return $this;
    }

    public function getQuantityPaymentTypes()
    {
        return $this->quantityPaymentTypes;
    }

    public function setQuantityPaymentTypes($quantityPaymentTypes)
    {
        $this->quantityPaymentTypes = $quantityPaymentTypes;

        return $this;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    public function getGift()
    {
        return $this->gift;
    }

    public function setGift($gift)
    {
        $this->gift = $gift;

        return $this;
    }

    public function getGiftMessage()
    {
        return $this->giftMessage;
    }

    public function setGiftMessage($giftMessage)
    {
        $this->giftMessage = $giftMessage;

        return $this;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if (!array_key_exists($status, self::$statuses)) {
            throw new InvalidArgumentException(sprintf('Invalid status (%s)', $status));
        }

        $this->status = $status;

        return $this;
    }

    public function getReanalysis()
    {
        return $this->reanalysis;
    }

    public function setReanalysis($reanalysis)
    {
        $this->reanalysis = $reanalysis;

        return $this;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     *
     * @return DateTime
     */
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    /**
     *
     * @param DateTime $reservationDate
     * @return Order
     */
    public function setReservationDate(DateTime $reservationDate)
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        if (!array_key_exists($product, self::$products)) {
            throw new InvalidArgumentException(sprintf('Invalid product type (%s)', $product));
        }

        $this->product = $product;

        return $this;
    }

    public function getListType()
    {
        return $this->listType;
    }

    public function setListType($listType)
    {
        if (!array_key_exists($listType, self::$listTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid list type (%s)', $listType));
        }

        $this->listType = $listType;

        return $this;
    }

    public function getListId()
    {
        return $this->listId;
    }

    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }

    /**
     *
     * @return Customer
     */
    public function getBillingData()
    {
        return $this->billingData;
    }

    /**
     *
     * @param Customer $billingData
     * @return Order
     */
    public function setBillingData(Customer $billingData)
    {
        $this->billingData = $billingData;

        return $this;
    }

    /**
     *
     * @return Customer
     */
    public function getShippingData()
    {
        return $this->shippingData;
    }

    /**
     *
     * @param Customer $shippingData
     * @return Order
     */
    public function setShippingData(Customer $shippingData)
    {
        $this->shippingData = $shippingData;

        return $this;
    }

    /**
     *
     * @return Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     *
     * @param int $index
     * @return Payment
     */
    public function getPayment($index)
    {
        return $this->payments[$index];
    }

    /**
     *
     * @param Payment[] $payments
     * @return Order
     */
    public function setPayments($payments)
    {
        foreach ($payments as $payment) {
            $this->addPayment($payment);
        }

        return $this;
    }

    /**
     *
     * @param Payment $payment
     * @return Order
     */
    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     *
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     *
     * @param Item[] $items
     * @return Order
     */
    public function setItems($items)
    {
        foreach ($items as $item) {
            $this->addItems($item);
        }

        return $this;
    }

    /**
     *
     * @param Item $item
     * @return Order
     */
    public function addItems(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     *
     * @return Passenger[]
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     *
     * @param Passenger[] $passengers
     * @return Order
     */
    public function setPassengers($passengers)
    {
        foreach ($passengers as $passenger) {
            $this->addPassenger($passenger);
        }

        return $this;
    }

    /**
     *
     * @param Passenger $passenger
     * @return Order
     */
    public function addPassenger(Passenger $passenger)
    {
        $this->passengers[] = $passenger;
        return $this;
    }

    /**
     *
     * @return Connection[]
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     *
     * @param Connection[] $connections
     * @return Order
     */
    public function setConnections($connections)
    {
        foreach ($connections as $connection) {
            $this->addConnection($connection);
        }

        return $this;
    }

    public function addConnection(Connection $connection)
    {
        $this->connections[] = $connection;
        return $this;
    }

    /**
     *
     * @return HotelReservation[]
     */
    public function getHotelReservations()
    {
        return $this->hotelReservations;
    }

    /**
     *
     * @param HotelReservation[] $hotelReservations
     * @return Order
     */
    public function setHotelReservations($hotelReservations)
    {
        foreach ($hotelReservations as $hotelReservation) {
            $this->addHotelReservation($hotelReservation);
        }
        return $this;
    }

    public function addHotelReservation(HotelReservation $hotelReservation)
    {
        $this->hotelReservations[] = $hotelReservation;

        return $this;
    }

    public function toXML($prettyPrint = false)
    {
        $xml = new XMLWriter;
        $xml->openMemory();
        $xml->setIndent($prettyPrint);

        $xml->startElement("ClearSale");
        $xml->startElement("Orders");
        $xml->startElement("Order");

        if ($this->fingerPrint) {
            $this->fingerPrint->toXML($xml);
        } else {
            throw new RequiredFieldException('Field FingerPrint of the Order object is required');
        }

        if ($this->id) {
            $xml->writeElement("ID", $this->id);
        } else {
            throw new RequiredFieldException('Field ID of the Order object is required');
        }

        if ($this->date) {
            $xml->writeElement("Date", $this->date->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field Date of the Order object is required');
        }

        if ($this->email) {
            $xml->writeElement("Email", $this->email);
        } else {
            throw new RequiredFieldException('Field E-mail of the Order object is required');
        }

        if ($this->ecommerceType) {
            $xml->writeElement("B2B_B2C", $this->ecommerceType);
        }

        if ($this->shippingPrice) {
            $xml->writeElement("ShippingPrice", $this->shippingPrice);
        }

        if ($this->totalItems) {
            $xml->writeElement("TotalItems", $this->totalItems);
        } else {
            throw new RequiredFieldException('Field TotalItems of the Order object is required');
        }

        if ($this->totalOrder) {
            $xml->writeElement("TotalOrder", $this->totalOrder);
        } else {
            throw new RequiredFieldException('Field TotalOrder of the Order object is required');
        }

        if ($this->quantityInstallments) {
            $xml->writeElement("QtyInstallments", $this->quantityInstallments);
        } else {
            throw new RequiredFieldException('Field QtyInstallments of the Order object is required');
        }

        if ($this->deliveryTime) {
            $xml->writeElement("DeliveryTimeCD", $this->deliveryTime);
        }

        if ($this->quantityItems) {
            $xml->writeElement("QtyItems", $this->quantityItems);
        }

        if ($this->quantityPaymentTypes) {
            $xml->writeElement("QtyPaymentTypes", $this->quantityPaymentTypes);
        }

        if ($this->ip) {
            $xml->writeElement("IP", $this->ip);
        } else {
            throw new RequiredFieldException('Field IP of the Order object is required');
        }

        // TODO: ShippingType not implemented

        if ($this->gift) {
            $xml->writeElement("Gift", $this->gift);
        }

        if ($this->giftMessage) {
            $xml->writeElement("GiftMessage", $this->giftMessage);
        }

        if ($this->notes) {
            $xml->writeElement("Obs", $this->notes);
        }

        if ($this->status) {
            $xml->writeElement("Status", $this->status);
        }

        if ($this->reanalysis) {
            $xml->writeElement("Reanalise", $this->reanalysis);
        }

        if ($this->origin) {
            $xml->writeElement("Origin", $this->origin);
        } else {
            throw new RequiredFieldException('Field Origin of the Order object is required');
        }

        if ($this->reservationDate) {
            $xml->writeElement("ReservationDate", $this->reservationDate->format(Order::DATE_TIME_FORMAT));
        }

        if ($this->country) {
            $xml->writeElement("Country", $this->country);
        }

        if ($this->nationality) {
            $xml->writeElement("Nationality", $this->nationality);
        }

        if ($this->product) {
            $xml->writeElement("Product", $this->product);
        }

        if ($this->listType) {
            $xml->writeElement("ListTypeID", $this->listType);
        }

        if ($this->listId) {
            $xml->writeElement("ListID", $this->listId);
        }

        if ($this->billingData) {
            $xml->startElement("BillingData");
            $this->billingData->toXML($xml);
            $xml->endElement();
        }

        if ($this->shippingData) {
            $xml->startElement("ShippingData");
            $this->shippingData->toXML($xml);
            $xml->endElement();
        }

        if (count($this->payments) > 0) {
            $xml->startElement("Payments");

            foreach ($this->payments as $payment) {
                $payment->toXML($xml);
            }

            $xml->endElement();
        }

        if (count($this->items) > 0) {
            $xml->startElement("Items");

            foreach ($this->items as $item) {
                $item->toXML($xml);
            }

            $xml->endElement();
        }

        if (count($this->passengers) > 0) {
            $xml->startElement("Passengers");

            foreach ($this->passengers as $passenger) {
                $passenger->toXML($xml);
            }

            $xml->endElement();
        }

        if (count($this->connections) > 0) {
            $xml->startElement("Connections");

            foreach ($this->connections as $connection) {
                $connection->toXML($xml);
            }

            $xml->endElement();
        }

        if (count($this->hotelReservations) > 0) {
            $xml->startElement("HotelReservations");

            foreach ($this->hotelReservations as $hotelReservation) {
                $hotelReservation->toXML($xml);
            }

            $xml->endElement();
        }

        $xml->endElement(); // Order
        $xml->endElement(); // Orders
        $xml->endElement(); // ClearSale

        return $xml->outputMemory(true);
    }
}
