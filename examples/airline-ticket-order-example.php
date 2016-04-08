<?php

date_default_timezone_set('America/Sao_Paulo');

require __DIR__.'/../vendor/autoload.php';

use ClearSale\ClearSaleAnalysis;
use ClearSale\Environment\Sandbox;
use ClearSale\XmlEntity\SendOrder\Address;
use ClearSale\XmlEntity\SendOrder\AbstractCustomer;
use ClearSale\XmlEntity\SendOrder\Connection;
use ClearSale\XmlEntity\SendOrder\CustomerBillingData;
use ClearSale\XmlEntity\SendOrder\CustomerShippingData;
use ClearSale\XmlEntity\SendOrder\FingerPrint;
use ClearSale\XmlEntity\SendOrder\HotelReservation;
use ClearSale\XmlEntity\SendOrder\Item;
use ClearSale\XmlEntity\SendOrder\Order;
use ClearSale\XmlEntity\SendOrder\Passenger;
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

    $passenger = Passenger::create('Fulano da Silva', Passenger::DOCUMENT_TYPE_CPF, '63165236372');
    $connection = createConnection();
    $hotelReservation = createHotelReservation();

    // Criar Pedido
    $order = Order::createAirlineTicketOrder(
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
        $item,
        $passenger,
        $connection,
        $hotelReservation
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

function createConnection()
{
    $company = 'TAM';
    $flightNumber = '3356';
    $flightDate = new \DateTime('2015-09-14 11:55:00');
    $class = 'Econômica';
    $from = 'GRU';
    $to = 'JPA';
    $departureDate = new \DateTime('2015-09-14 11:55:00');
    $arrivalDate = new \DateTime('2015-09-14 15:33:00');

    return Connection::create(
        $company,
        $flightNumber,
        $flightDate,
        $class,
        $from,
        $to,
        $departureDate,
        $arrivalDate
    );
}

function createHotelReservation()
{
    $hotel = 'Hotel Beira Mar';
    $city = 'João Pessoa';
    $state = 'Paraíba';
    $country = 'Brasil';
    $reservationDate = new \DateTime('2015-07-01 15:30:00');
    $reservationExpirationDate = new \DateTime('2015-07-15 00:00:00');
    $checkInDate = new \DateTime('2015-09-14 14:00:00');
    $checkOutDate = new \DateTime('2015-09-21 12:00:00');

    return HotelReservation::create(
        $hotel,
        $city,
        $state,
        $country,
        $reservationDate,
        $reservationExpirationDate,
        $checkInDate,
        $checkOutDate
    );
}
