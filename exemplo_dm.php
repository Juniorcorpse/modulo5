<?php
require_once 'classes/dm/Produto.php';
require_once 'classes/dm//Venda.php';
require_once 'classes/dm/VendaMapper.php';

try {
    $conn = new PDO("mysql:dbname=estoque;host=localhost", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $p1 = new Produto;
    $p1->id = 1;
    $p1->preco = 12;

    $p2 = new Produto;
    $p2->id = 2;
    $p2->preco = 12;

    $venda = new Venda;
    $venda->addItem(12, $p1);
    $venda->addItem(20, $p2);

    VendaMapper::setConnection($conn);
    VendaMapper::save($venda);

} catch (Exception $e) {
    print $e->getMessage();
}