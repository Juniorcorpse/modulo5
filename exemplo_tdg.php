<?php

require_once 'classes/tdg/ProdutoGateway.php';

try {
    $conn = new PDO("mysql:dbname=estoque;host=localhost", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    ProdutoGateway::setConnection($conn);
/* */
    $data = new stdClass;
    $data->descricao = 'Vinho';
    $data->estoque = 8;
    $data->preco_custo = 12;
    $data->preco_venda = 18;
    $data->codigo_barras ='2343244';
    $data->data_cadastro = date('Y-m-d');
    $data->origem = 'N';

    $gw = new ProdutoGateway;
    $gw->save($data);

    $gw = new ProdutoGateway;
    $produto = $gw->find(1);
    $produto->estoque += 2;
    $gw->save($produto);

    $gw = new ProdutoGateway;
    foreach($gw->all('estoque <= 8') as $produto)
    {
        print $produto->descricao. '<br/>';
    }

} catch (Exception $e) {
    print $e->getMessage();
}