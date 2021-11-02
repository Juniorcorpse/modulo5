<?php
require_once 'classes/ar/Produto.php';
require_once 'classes/api/Connection.php';

try {
    //code...
    $conn = Connection::open('estoque');
    Produto::setConnection($conn);

    $produto = new Produto;
    $produto->descricao = 'Feijão';
    $produto->estoque = 8;
    $produto->preco_custo = 12;
    $produto->preco_venda = 18;
    $produto->codigo_barras ='2343244';
    $produto->data_cadastro = date('Y-m-d');
    $produto->origem = 'N';
    $produto->save();
} catch (\PDOException $pdoex) {
    print $pdoex->getMessage();
}