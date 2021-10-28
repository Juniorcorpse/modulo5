<?php
//ActiveRecord
require_once 'classes/ar/Produto.php';

try {
    $conn = new PDO("mysql:dbname=estoque;host=localhost", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    Produto::setConnection($conn);

    foreach(Produto::all() as $produto){
        $produto->delete();
    }

    $produto = new Produto;
    $produto->descricao = 'Vinho';
    $produto->estoque = 8;
    $produto->preco_custo = 12;
    $produto->preco_venda = 18;
    $produto->codigo_barras ='2343244';
    $produto->data_cadastro = date('Y-m-d');
    $produto->origem = 'N';
    $produto->save();

    $outro = $produto::find(1);

    var_dump(
        $outro->descricao, 
        $outro->estoque,
        $outro->preco_custo,
        $outro->preco_venda,
        $outro->codigo_barras,
        $outro->data_cadastro,   
        $outro->getMargemLucro()    

    ) ;


    print  $outro->registrarCompra(14, 5);
    $outro->save();

} catch (Exception $e) {
    print $e->getMessage();
}