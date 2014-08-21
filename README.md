# ClearSale

## Utilização

### Definir as variáveis de ambiente

CLEARSALE_ENVIRONMENT = 'staging'
CLEARSALE_ENTITY_CODE = '<ENTITY CODE>'

```PHP
try {
    $order = new ClearSale\Order();
    $order->setFingerPrint($fingerPrint)
        ->setId($orderId)
        ->setDate(time(), true)
        ->setEmail($email)
        ->setDeliveryTime(???????)
        ->setShippingPrice($price])
        ->setTotalItems($totalItems)
        ->setTotalOrder($orderTotal)
        ->setBillingData($customer)
        ->setShippingData($customer)
        ->setItems($items)
        ->setPayments($payments);

    // Solicitação de análise
    $clearSale = new ClearSaleAnalysis(CLEARSALE_ENTITY_CODE, CLEARSALE_ENVIRONMENT);
    $response = $clearSale->analysis($order);

    // Resultado da análise
    switch ($response)
    {
        case ClearSaleAnalysis::APROVADO:
            // Análise aprovou a cobrança, realizar o pagamento

            break;
        case ClearSaleAnalysis::REPROVADO:
            // Análise não aprovou a cobrança

            break;
        case ClearSaleAnalysis::AGUARDANDO_APROVACAO:
            // Análise pendente de aprovação manual

            break;
    }
} catch (Exception $e) {
    // Erro genérico da análise
}
```

OBS: Após a requisição de cobrança, deve-se informar a ClearSale sobre o status retornado pelo gateway de pagamento

- Se a cobrança for realizada com sucesso pelo gateway de pagamento
```PHP
$clearSale->updateOrderStatusId($orderId, ClearSaleAnalysis::APROVADO);
```

```PHP
- Se a cobrança não for autorizada pelo gateway de pagamento
$clearSale->updateOrderStatusId($orderId, ClearSaleAnalysis::REPROVADO);
```