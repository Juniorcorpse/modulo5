<?php
//ActiveRecord
require_once 'classes/ar/Produto.php';

try {
    $conn = new PDO("mysql:dbname=estoque;host=localhost", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    Produto::setConnection($conn);

    $produto = new Produto;
    $produto->descricao = 'Vinho';
    $produto->estoque = 8;
    $produto->preco_custo = 12;
    $produto->preco_venda = 18;
    $produto->codigo_barras ='2343244';
    $produto->data_cadastro = date('Y-m-d');
    $produto->origem = 'N';
    $produto->save();

} catch (Exception $e) {
    print $e->getMessage();
}