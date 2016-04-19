# ClearSale API

[![Build Status](https://travis-ci.org/lucasmro/ClearSale.png)](https://travis-ci.org/lucasmro/ClearSale)
[![Latest Stable Version](https://poser.pugx.org/lucasmro/clearsale/v/stable)](https://packagist.org/packages/lucasmro/clearsale)
[![Total Downloads](https://poser.pugx.org/lucasmro/clearsale/downloads)](https://packagist.org/packages/lucasmro/clearsale)
[![Latest Unstable Version](https://poser.pugx.org/lucasmro/clearsale/v/unstable)](https://packagist.org/packages/lucasmro/clearsale)
[![License](https://poser.pugx.org/lucasmro/clearsale/license)](https://packagist.org/packages/lucasmro/clearsale)

This library makes it easy for PHP developers to integrate their code with the ClearSale platform.

## What is ClearSale?

ClearSale is a Brazilian fraud risk management company that acts in the physical and virtual world, with solutions
for e-commerce, credit, billing and sales recovery.

## Requirements

PHP 5.3+

## Installation

The easiest way to install the library is through [Composer](http://getcomposer.org/).

```JSON
{
    "require": {
        "lucasmro/clearsale": "dev-master"
    }
}
```

## Integration Flow

This flow is responsible for demonstrating the integration between the client and ClearSale:

    Store                                                                 ClearSale
     |                                                                       |
     |----- (A) risk analysis request (sendOrders) ------------------------->|
     |                                                                       | (B) performs processing
     |<---- (C) sends response ----------------------------------------------|
     |                                                                       |
     |----- (D) performs billing / cancel the purchase / try again --------->|

* (A) The store sends a risk analysis request, informing the purchase data and the buyer information.
* (B) ClearSale processes the request.
* (C) ClearSale responds to the request.
* (D) If the response (C) is approved, the store should perform the billing request.
* (D) If the response (C) is rejected, the store must not perform the billing request.
* (D) If the response (C) is awaiting approval, the store should conduct further verifications on the ClearSale
platform until the status of the analysis changes to approved or rejected.

## Usage

You will need to have the Entity Code previously provided by ClearSale in order to make requests in the ClearSale platform.

The code snippet below is a basic example of how to perform a risk analysis request:

```PHP

try {
    $order = new \ClearSale\Order();
    $order->setFingerPrint($fingerPrint)
        ->setId($orderId)
        ->setDate($date)
        ->setEmail($email)
        ->setTotalItems($totalItems)
        ->setTotalOrder($orderTotal)
        ->setQuantityInstallments($quantityInstallments);
        ->setIp($ip);
        ->setOrigin($origin);
        ->setBillingData($customer)
        ->setShippingData($customer)
        ->setItems($items)
        ->setPayments($payments);

    // Environment
    $environment = new \ClearSale\Environment\Sandbox('<CLEARSALE_ENTITY_CODE>');

    // Risk analysis request
    $clearSale = new \ClearSale\ClearSaleAnalysis($environment);
    $response = $clearSale->analysis($order);

    // Analysis result
    switch ($response)
    {
        case \ClearSale\ClearSaleAnalysis::APROVADO:
            // Risk analysis was approved, you can charge the buyer's order
            break;
        case \ClearSale\ClearSaleAnalysis::REPROVADO:
            // Risk analysis was not approved, you can not charge the buyer's order
            break;
        case \ClearSale\ClearSaleAnalysis::AGUARDANDO_APROVACAO:
            // Risk analysis status is waiting for approval.
            break;
    }
} catch (\Exception $e) {
    // Generic error analysis
}
```

After performing the billing request with your payment gateway, you should inform the ClearSale about the result status of the billing.

* If the charge was authorized:

```PHP
$clearSale->updateOrderStatusId($orderId, \ClearSale\ClearSaleAnalysis::APROVADO);
```

* If the charge was unauthorized:

```PHP
$clearSale->updateOrderStatusId($orderId, \ClearSale\ClearSaleAnalysis::REPROVADO);
```

## Documentation

You can find the ClearSale documentation for integrating in the [docs](docs) directory.

## Examples

You can find some examples ready for use in the [examples](examples) directory.

* [Example for E-Commerce order](examples/ecommerce-order-example.php)

* [Example for Airline Tickets order](examples/airline-ticket-order-example.php)
