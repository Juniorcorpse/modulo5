<?php

require_once 'classes/ar/ProdutoTransactionELog.php';
require_once 'classes/api/Connection.php';
require_once 'classes/api/Transaction.php';
require_once 'classes/api/Logger.php';
require_once 'classes/api/LoggerTXT.php';

try {
    
    Transaction::open('estoque');
    Transaction::setLogger(new LoggerTXT('log.txt'));

    $produto = new ProdutoTransactionELog;
    $produto->descricao = 'Café ProdutoTransactionELog';
    $produto->estoque = 89;
    $produto->preco_custo = 10;
    $produto->preco_venda = 17;
    $produto->codigo_barras ='10101010';
    $produto->data_cadastro = date('Y-m-d');
    $produto->origem = 'N';
    $produto->save();

    Transaction::close();

} catch (\PDOException $pdoex) {
    Transaction::rollback();
    print $pdoex->getMessage();
}