# API ClearSale

**To read the documentation in English, please access the [README.eng.md](README.eng.md) file.**

[![Build Status](https://travis-ci.org/lucasmro/ClearSale.png)](https://travis-ci.org/lucasmro/ClearSale)

API de integração com a ClearSale.

## O que é ClearSale?

A Clearsale é uma empresa brasileira para gestão de risco de fraude que atua no mundo físico e virtual, com soluções
para e-commerce, crédito, cobrança e recuperação de vendas.

## Requisitos

PHP 5.3+

## Instalação

A maneira mais fácil de instalar a biblioteca é através do [Composer](http://getcomposer.org/).

```JSON
{
    "require": {
        "lucasmro/clearsale": "dev-master"
    }
}
```

## Fluxo de integração

Este fluxo é responsável por demonstrar a integração entre o cliente e a ClearSale:

    Loja                                                                 ClearSale
     |                                                                       |
     |----- (A) solicitação de análise de risco (sendOrders) --------------->|
     |                                                                       | (B) realiza processamento
     |<---- (C) envia resposta ----------------------------------------------|
     |                                                                       |
     |----- (D) realiza a cobrança / cancela a compra / tenta novamente ---->|

* (A) A loja realiza uma solicitação de análise de risco, informando os dados da compra e do comprador.
* (B) A ClearSale processa a requisição.
* (C) A ClearSale responde a requisição.
* (D) Caso a resposta de (C) seja aprovada, a loja deverá realizar a cobrança.
* (D) Caso a resposta de (C) seja reprovada, a loja não deverá realizar a cobrança.
* (D) Caso a resposta de (C) seja aguardando aprovação, a loja deverá realizar novas consultas na plataforma na
ClearSale até que o status da análise mude para aprovado ou reprovado.

## Utilização

Será necessário possuir o EntityCode fornecido pela ClearSale para poder realizar as requisições nos ambientes de
homologação e produção.

O trecho de código abaixo é um exemplo básico de como realizar a solicitação de análise de risco:

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

    // Definir ambiente
    $environment = new \ClearSale\Environment\Sandbox('<CLEARSALE_ENTITY_CODE>');

    // Solicitação de análise
    $clearSale = new \ClearSale\ClearSaleAnalysis($environment);
    $response = $clearSale->analysis($order);

    // Resultado da análise
    switch ($response)
    {
        case \ClearSale\ClearSaleAnalysis::APROVADO:
            // Análise aprovou a cobrança, realizar o pagamento
            break;
        case \ClearSale\ClearSaleAnalysis::REPROVADO:
            // Análise não aprovou a cobrança
            break;
        case \ClearSale\ClearSaleAnalysis::AGUARDANDO_APROVACAO:
            // Análise pendente de aprovação manual
            break;
    }
} catch (\Exception $e) {
    // Erro genérico da análise
}
```

Após realizar a requisição de cobrança, deve-se informar a ClearSale sobre o status do processamento do pagamento.

* Se a cobrança for autorizada:

```PHP
$clearSale->updateOrderStatusId($orderId, \ClearSale\ClearSaleAnalysis::APROVADO);
```

* Se a cobrança não for autorizada:

```PHP
$clearSale->updateOrderStatusId($orderId, \ClearSale\ClearSaleAnalysis::REPROVADO);
```

## Documentação

Você pode encontrar a documentação de integração da ClearSale no diretório [docs](docs).

## Exemplos

Você pode encontrar alguns exemplos prontos para uso no diretório [examples](examples).

* [Exemplo de pedido de E-Commerce](examples/ecommerce-order-example.php)

* [Exemplo de pedido de Passagem Aérea](examples/airline-ticket-order-example.php)
