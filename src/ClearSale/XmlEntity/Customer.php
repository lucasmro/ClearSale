<?php

namespace ClearSale\XmlEntity;

use ClearSale\Exception\RequiredFieldException;
use DateTime;
use InvalidArgumentException;
use XMLWriter;

class Customer implements XmlEntityInterface
{
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

    /**
     *
     * @var string
     */
    private $id;

    /**
     *
     * @var int
     */
    private $type;

    /**
     *
     * @var string
     */
    private $legalDocument1;

    /**
     *
     * @var string
     */
    private $legalDocument2;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var DateTime
     */
    private $birthDate;

    /**
     *
     * @var string
     */
    private $email;

    /**
     *
     * @var string
     */
    private $gender;

    /**
     *
     * @var Address
     */
    private $address;

    /**
     *
     * @var Phone[]
     */
    private $phones;

    /**
     *
     * @param string $id
     * @param string $type
     * @param string $legalDocument
     * @param string $name
     * @param Address $address
     * @param Phone $phone
     * @return Customer
     */
    public static function create($id, $type, $legalDocument, $name, Address $address, array $phone)
    {
        $instance = new self();

        $instance->setId($id);
        $instance->setType($type);
        $instance->setLegalDocument1($legalDocument);
        $instance->setName($name);
        $instance->setAddress($address);
        $instance->addPhone($phone);

        return $instance;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $id
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function setId($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('The id value is empty!');
        }

        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, self::$customerTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid type (%s)', $type));
        }

        $this->type = $type;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLegalDocument1()
    {
        return $this->legalDocument1;
    }

    /**
     *
     * @param string $legalDocument1
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function setLegalDocument1($legalDocument1)
    {
        $legalDocument1 = preg_replace('/[^0-9]/', '', $legalDocument1);

        if (empty($legalDocument1)) {
            throw new InvalidArgumentException('LegalDocument1 is empty!');
        }

        $this->legalDocument1 = $legalDocument1;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLegalDocument2()
    {
        return $this->legalDocument2;
    }

    /**
     *
     * @param string $legalDocument2
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function setLegalDocument2($legalDocument2)
    {
        $legalDocument2 = preg_replace('/[^0-9]/', '', $legalDocument2);

        if (empty($legalDocument2)) {
            throw new InvalidArgumentException('LegalDocument2 is empty!');
        }

        $this->legalDocument2 = $legalDocument2;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return Customer
     * @throws InvalidArgumentException
     */
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
     *
     * @param DateTime $birthDate
     * @return Customer
     */
    public function setBirthDate(DateTime $birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     *
     * @param string $gender
     * @return Customer
     * @throws InvalidArgumentException
     */
    public function setGender($gender)
    {
        if (!in_array($gender, self::$genderTypes)) {
            throw new InvalidArgumentException(sprintf('Invalid gender (%s)', $gender));
        }

        $this->gender = $gender;

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

    /**
     *
     * @param Address $address
     * @return Customer
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     *
     * @return Phone[]
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     *
     * @param Phone|Phone[] $phones
     * @return Customer
     */
    public function setPhones($phones)
    {
        foreach ((array)$phones as $phone) {
            $this->addPhone($phone);
        }

        return $this;
    }

    /**
     *
     * @param Phone $phone
     * @return Customer
     */
    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     *
     * @param XMLWriter $xml
     */
    public function toXML(XMLWriter $xml)
    {
        if ($this->id) {
            $xml->writeElement("ID", $this->id);
        } else {
            throw new RequiredFieldException('Field ID of the Customer object is required');
        }

        if ($this->type) {
            $xml->writeElement("Type", $this->type);
        } else {
            throw new RequiredFieldException('Field Type of the Customer object is required');
        }

        if ($this->legalDocument1) {
            $xml->writeElement("LegalDocument1", $this->legalDocument1);
        } else {
            throw new RequiredFieldException('Field LegalDocument1 of the Customer object is required');
        }

        if ($this->legalDocument2) {
            $xml->writeElement("LegalDocument2", $this->legalDocument2);
        }

        if ($this->name) {
            $xml->writeElement("Name", $this->name);
        } else {
            throw new RequiredFieldException('Field name of the Customer object is required');
        }

        if ($this->birthDate) {
            $xml->writeElement("BirthDate", $this->birthDate->format(Order::DATE_TIME_FORMAT));
        } else {
            throw new RequiredFieldException('Field BirthDate of the Customer object is required');
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
