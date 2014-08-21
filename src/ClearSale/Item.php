<?php

namespace ClearSale;

class Item
{
    private $id;
    private $name;
    private $value;
    private $quantity;
    private $isGift;
    private $categoryId;
    private $categoryName;

    public function __construct()
    {

    }

    /**
     * Criar Item com campos obrigatórios preenchidos
     *
     * @param String $id - Código do Produto
     * @param String $name - Nome do Produto
     * @param Float $value - Valor Unitário
     * @param Integer $quantity - Quantidade
     *
     * @return \Lucasmro\ClearSale\Item
     */
    public static function create($id, $name, $value, $quantity)
    {
        $instance = new self();

        $instance->setId($id);
        $instance->setName($name);
        $instance->setValue($value);
        $instance->setQuantity($quantity);

        return $instance;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Id is empty!');
        }

        $this->id = $id;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name is empty!');
        }

        $this->name = $name;

        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value)
    {
        if (!is_float($value)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid value', $value)
            );
        }

        $this->value = $value;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        if (!is_int($quantity)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid quantity', $quantity)
            );
        }

        $this->quantity = $quantity;

        return $this;
    }

    public function isGift()
    {
        return $this->giftTypeId;
    }

    public function setGift($gift)
    {
        if (!is_bool($gift)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid gift value', $gift)
            );
        }

        $this->isGift = $gift;

        return $this;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        if (!is_int($categoryId)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid categoryId', $categoryId)
            );
        }

        $this->categoryId = $categoryId;

        return $this;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function setCategoryName($categoryName)
    {
        if (empty($categoryName)) {
            throw new \InvalidArgumentException('Category name is empty!');
        }

        $this->categoryName = $categoryName;

        return $this;
    }

    public function toXML(\XMLWriter $xml)
    {
        $xml->startElement("Item");

        if ($this->id) {
            $xml->writeElement("ID", $this->id);
        }

        if ($this->name) {
            $xml->writeElement("Name", $this->name);
        }

        if ($this->value) {
            $xml->writeElement("ItemValue", $this->value);
        }

        if ($this->quantity) {
            $xml->writeElement("Qty", $this->quantity);
        }

        if ($this->isGift) {
            $xml->writeElement("GiftTypeID", (int) $this->isGift);
        }

        if ($this->categoryId) {
            $xml->writeElement("CategoryID", $this->categoryId);
        }

        if ($this->categoryName) {
            $xml->writeElement("CategoryName", $this->categoryName);
        }

        $xml->endElement();
    }
}
