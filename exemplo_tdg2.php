<?php
require_once 'classes/tdg/Produto.php';
require_once 'classes/tdg/ProdutoGateway.php';

try {
    $conn = new PDO("mysql:dbname=estoque;host=localhost", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    Produto::setConnection($conn);
/* */
    $produtos = Produto::all();
    foreach($produtos as $produto){
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

    $prodUpdate = Produto::find(1);
    print 'Descricão: '.$prodUpdate->descricao.'<br/>';
    print 'Margem de lucro: '.$prodUpdate->getMargemLucro().'<br/>';
    $prodUpdate->registrarCompra(14, 5).'<br/>';
    $prodUpdate->save();

} catch (Exception $e) {
    print $e->getMessage();
}