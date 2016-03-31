<?php

namespace ClearSale\XmlEntity;

use DateTime;
use InvalidArgumentException;
use XMLWriter;

class Customer implements XmlEntityInterface
{
    const DATE_TIME_FORMAT     = 'Y-m-d\TH:i:s';
    const TYPE_PESSOA_FISICA   = 1;
    const TYPE_PESSOA_JURIDICA = 2;

    private static $customerTypes = array(
        self::TYPE_PESSOA_FISICA,
        self::TYPE_PESSOA_JURIDICA,
    );

    const GENDER_MASCULINO = 'M';
    const GENDER_FEMININO  = 'F';

    private static $genderTypes = array(
        self::GENDER_MASCULINO,
        self::GENDER_FEMININO,
    );
    private $id;
    private $type;
    private $legalDocument1;
    private $legalDocument2;
    private $name;
    private $birthDate;
    private $email;
    private $gender;
    private $address;
    private $phones;

    public function __construct()
    {

    }

    public static function create($id, $type, $legalDocument1, $name, Address $address, $phones)
    {
        $instance = new self();

        $instance->setId($id);
        $instance->setType($type);
        $instance->setLegalDocument1($legalDocument1);
        $instance->setName($name);
        $instance->setAddress($address);
        $instance->setPhones($phones);

        return $instance;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('The id value is empty!');
        }

        $this->id = $id;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!in_array($type, self::$customerTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid type (%s)', $type));
        }

        $this->type = $type;

        return $this;
    }

    public function getLegalDocument1()
    {
        return $this->legalDocument1;
    }

    public function setLegalDocument1($legalDocument1)
    {
        $legalDocument1 = preg_replace('/[^0-9]/', '', $legalDocument1);

        if (empty($legalDocument1)) {
            throw new InvalidArgumentException('LegalDocument1 is empty!');
        }

        $this->legalDocument1 = $legalDocument1;

        return $this;
    }

    public function getLegalDocument2()
    {
        return $this->legalDocument2;
    }

    public function setLegalDocument2($legalDocument2)
    {
        $legalDocument2 = preg_replace('/[^0-9]/', '', $legalDocument2);

        if (empty($legalDocument2)) {
            throw new InvalidArgumentException('LegalDocument2 is empty!');
        }

        $this->legalDocument2 = $legalDocument2;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Name is empty!');
        }

        $this->name = $name;

        return $this;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set birthDate in format "Y-m-d" or UNIX_TIMESTAMP
     *
     * @param $birthDate
     * @param bool $isUnixTimestampFormat
     * @return self
     */
    public function setBirthDate($birthDate, $isUnixTimestampFormat = false)
    {
        if (!$isUnixTimestampFormat) {
            $datetime = new DateTime($birthDate);
        } else {
            $datetime = new DateTime();
            $datetime->setTimestamp($birthDate);
        }

        $this->birthDate = $datetime->format(self::DATE_TIME_FORMAT);

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

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        if (!in_array($gender, self::$genderTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid gender (%s)', $gender));
        }

        $this->gender = $gender;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    public function setPhones($phones)
    {
        foreach ($phones as $phone) {
            $this->addPhone($phone);
        }

        return $this;
    }

    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    public function toXML(XMLWriter $xml)
    {
        if ($this->id) {
            $xml->writeElement("ID", $this->id);
        }

        if ($this->type) {
            $xml->writeElement("Type", $this->type);
        }

        if ($this->legalDocument1) {
            $xml->writeElement("LegalDocument1", $this->legalDocument1);
        }

        if ($this->legalDocument2) {
            $xml->writeElement("LegalDocument2", $this->legalDocument2);
        }

        if ($this->name) {
            $xml->writeElement("Name", $this->name);
        }

        if ($this->birthDate) {
            $xml->writeElement("BirthDate", $this->birthDate);
        }

        if ($this->email) {
            $xml->writeElement("Email", $this->email);
        }

        if ($this->gender) {
            $xml->writeElement("Gender", $this->gender);
        }

        if ($this->address) {
            $this->address->toXML($xml);
        }

        if (count($this->phones) > 0) {
            $xml->startElement("Phones");

            foreach ($this->phones as $phone) {
                $phone->toXML($xml);
            }

            $xml->endElement();
        }
    }
}
