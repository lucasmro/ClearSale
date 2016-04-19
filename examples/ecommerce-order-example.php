<?php

date_default_timezone_set('America/Sao_Paulo');

require __DIR__.'/../vendor/autoload.php';

use ClearSale\ClearSaleAnalysis;
use ClearSale\Environment\Sandbox;
use ClearSale\XmlEntity\SendOrder\Address;
use ClearSale\XmlEntity\SendOrder\AbstractCustomer;
use ClearSale\XmlEntity\SendOrder\CustomerBillingData;
use ClearSale\XmlEntity\SendOrder\CustomerShippingData;
use ClearSale\XmlEntity\SendOrder\FingerPrint;
use ClearSale\XmlEntity\SendOrder\Item;
use ClearSale\XmlEntity\SendOrder\Order;
use ClearSale\XmlEntity\SendOrder\Payment;
use ClearSale\XmlEntity\SendOrder\Phone;

try {
    // Dados da Integração com a ClearSale
    $entityCode = '<CLEARSALE_ENTITY_CODE>';
    $environment = new Sandbox($entityCode);

    // Dados do Pedido
    $fingerPrint = new FingerPrint(createSessionId());
    $orderId = createOrderId();
    $date = new \DateTime();
    $email = 'cliente@clearsale.com.br';
    $totalItems = 10.0;
    $totalOrder = 17.5;
    $quantityInstallments = 1;
    $ip = '127.0.0.1';
    $origin = 'WEB';
    $customerBillingData = createCustomerBillingData();
    $customerShippingData = createCustomerShippingData();
    $item = Item::create(1, 'Adaptador USB', 10.0, 1);
    $payment = Payment::create(Payment::BOLETO_BANCARIO, new \DateTime(), 17.5);

    // Criar Pedido
    $order = Order::createEcommerceOrder(
        $fingerPrint,
        $orderId,
        $date,
        $email,
        $totalItems,
        $totalOrder,
        $quantityInstallments,
        $ip,
        $origin,
        $customerBillingData,
        $customerShippingData,
        $payment,
        $item
    );

    // Enviar pedido para análise
    $clearSale = new ClearSaleAnalysis($environment);
    $response = $clearSale->analysis($order);

    // Resultado da análise
    switch ($response)
    {
        case ClearSaleAnalysis::APROVADO:
            // Análise aprovou a cobrança, realizar o pagamento

            echo 'Aprovado' . PHP_EOL;

            break;
        case ClearSaleAnalysis::REPROVADO:
            // Análise não aprovou a cobrança

            echo 'Reprovado' . PHP_EOL;

            break;
        case ClearSaleAnalysis::AGUARDANDO_APROVACAO:
            // Análise pendente de aprovação manual

            echo 'Aguardando aprovação manual' . PHP_EOL;

            break;
    }
} catch (Exception $e) {
    // Erro genérico da análise
    echo $e->getMessage();
}

function createOrderId()
{
    return sprintf('TEST-%s', createSessionId());
}

function createSessionId()
{
    return md5(uniqid(rand(), true));
}

function createCustomerBillingData()
{
    $id = '1';
    $legalDocument = '63165236372';
    $name = 'Fulano da Silva';
    $address = createAddress();
    $phone = Phone::create(Phone::COMERCIAL, '11', '37288788');
    $birthDate = new \DateTime('1980-01-01');

    return CustomerBillingData::create(
        $id,
        AbstractCustomer::TYPE_PESSOA_FISICA,
        $legalDocument,
        $name,
        $address,
        $phone,
        $birthDate
    );
}

function createCustomerShippingData()
{
    $id = '1';
    $legalDocument = '63165236372';
    $name = 'Fulano da Silva';
    $address = createAddress();
    $phone = Phone::create(Phone::COMERCIAL, '11', '37288788');

    return CustomerShippingData::create(
        $id,
        AbstractCustomer::TYPE_PESSOA_FISICA,
        $legalDocument,
        $name,
        $address,
        $phone
    );
}

function createAddress()
{
    $street = 'Rua José de Oliveira Coutinho';
    $number = 151;
    $county = 'Barra Funda';
    $country = 'Brasil';
    $city = 'São Paulo';
    $state = 'SP';
    $zip = '01144020';

    return Address::create($street, $number, $county, $country, $city, $state, $zip);
}
