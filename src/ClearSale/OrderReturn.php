<?php

namespace ClearSale;

class OrderReturn
{
    /* Pedido foi aprovado automaticamente segundo parâmetros definidos na regra de aprovação automática. */
    const STATUS_SAIDA_APROVACAO_AUTOMATICA    = 'APA';
    /* Pedido aprovado manualmente por tomada de decisão de um analista. */
    const STATUS_SAIDA_APROVACAO_MANUAL        = 'APM';
    /* Pedido Reprovado sem Suspeita por falta de contato com o cliente dentro do período acordado e/ou políticas restritivas de CPF (Irregular, SUS ou Cancelados). */
    const STATUS_SAIDA_REPROVADA_SEM_SUSPEITA  = 'RPM';
    /* Pedido está em fila para análise */
    const STATUS_SAIDA_ANALISE_MANUAL          = 'AMA';
    /* Ocorreu um erro na integração do pedido, sendo necessário analisar um possível erro no XML enviado e após a correção reenvia-lo. */
    const STATUS_SAIDA_ERRO                    = 'ERR';
    /* Pedido importado e não classificado Score pela analisadora (processo que roda o Score de cada pedido). */
    const STATUS_SAIDA_NOVO                    = 'NVO';
    /* Pedido Suspenso por suspeita de fraude baseado no contato com o “cliente” ou ainda na base ClearSale. */
    const STATUS_SAIDA_SUSPENSAO_MANUAL        = 'SUS';
    /* Cancelado por solicitação do cliente ou duplicidade do pedido. */
    const STATUS_SAIDA_CANCELADO_PELO_CLIENTE  = 'CAN';
    /* Pedido imputado como Fraude Confirmada por contato com a administradora de cartão e/ou contato com titular do cartão ou CPF do cadastro que desconhecem a compra. */
    const STATUS_SAIDA_FRAUDE_CONFIRMADA       = 'FRD';
    /* Pedido Reprovado Automaticamente por algum tipo de Regra de Negócio que necessite aplicá-la (Obs: não usual e não recomendado). */
    const STATUS_SAIDA_REPROVACAO_AUTOMATICA   = 'RPA';
    /* Pedido reprovado automaticamente por política estabelecida pelo cliente ou ClearSale. */
    const STATUS_SAIDA_REPROVACAO_POR_POLITICA = 'RPP';

    private $id;
    private $status;
    private $score;

    public function __construct($id, $status, $score)
    {
        $this->id     = $id;
        $this->status = $status;
        $this->score  = $score;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getScore()
    {
        return $this->score;
    }
}
