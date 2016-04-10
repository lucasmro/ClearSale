# API ClearSale

[![Build Status](https://travis-ci.org/lucasmro/ClearSale.png)](https://travis-ci.org/lucasmro/ClearSale)

API de integração com a ClearSale.

## O que é ClearSale?

A Clearsale é uma empresa brasileira para gestão de risco de fraude que atua no mundo físico e virtual, com soluções
para e-commerce, crédito, cobrança e recuperação de vendas.

## Requisitos

PHP 5.3+

## Instalação

A maneira mais fácil de instalar a biblioteca é através do Composer.

TODO: Cadastrar a biblioteca no packagist

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

TODO: Separar o fluxo para demonstrar melhor os 3 cenários acima.

## Utilização

Será necessário possuir o EntityCode fornecido pela ClearSale para poder realizar as requisições nos ambientes de
homologação e produção.

TODO: Renomear as referências no código de staging para sandbox

O trecho de código abaixo é um exemplo básico de como realizar a solicitação de análise de risco:

```PHP

try {
    $order = new \ClearSale\Order();
    $order->setFingerPrint($fingerPrint)
        ->setId($orderId)
        ->setDate(time(), true)
        ->setEmail($email)
        ->setDeliveryTime($deliveryTime)
        ->setShippingPrice($price)
        ->setTotalItems($totalItems)
        ->setTotalOrder($orderTotal)
        ->setBillingData($customer)
        ->setShippingData($customer)
        ->setItems($items)
        ->setPayments($payments);

    // Cria-se o objeto do ambiente
    $environment = new \ClearSale\Environment\Sandbox('CLEARSALE_ENTITY_CODE');

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

TODO: Substituir a string de environment pela instância de um objeto. Ex: new Sandbox() ou new Production().

Após realizar a requisição de cobrança, deve-se informar a ClearSale sobre o status do processamento do pagamento.

* Se a cobrança for autorizada:

```PHP
$clearSale->updateOrderStatusId($orderId, ClearSaleAnalysis::APROVADO);
```

* Se a cobrança não for autorizada:

```PHP
$clearSale->updateOrderStatusId($orderId, ClearSaleAnalysis::REPROVADO);
```

## Licença de uso

Esta biblioteca segue os termos de uso ????.

TODO: Qual licença utilizar?