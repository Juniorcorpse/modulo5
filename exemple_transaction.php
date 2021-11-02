<?php

require_once 'classes/ar/ProdutoTransaction.php';
require_once 'classes/api/Connection.php';
require_once 'classes/api/Transaction.php';

try {
    
    Transaction::open('estoque');

    $produto = new ProdutoTransaction;
    $produto->descricao = 'Café Torrado';
    $produto->estoque = 80;
    $produto->preco_custo = 12;
    $produto->preco_venda = 18;
    $produto->codigo_barras ='32335554';
    $produto->data_cadastro = date('Y-m-d');
    $produto->origem = 'N';
    $produto->save();

    Transaction::close();

} catch (\PDOException $pdoex) {
    Transaction::rollback();
    print $pdoex->getMessage();
}