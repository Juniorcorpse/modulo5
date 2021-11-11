<?php
require_once 'classes/api/Transaction.php';
require_once 'classes/api/Connection.php';
require_once 'classes/api/Logger.php';
require_once 'classes/api/LoggerTXT.php';
require_once 'classes/api/Record.php';
require_once 'classes/model/Produto.php';

try {
    Transaction::open('estoque');
    Transaction::setLogger(new LoggerTXT('log.txt'));
    $produto = Produto::find(1);
    if ($produto) {
        //print "Produto find: ".$produto->descricao;
        //$produto->estoque += 5;
        //$produto->store();
        $produto->delete();
        
    }
    //$produto = new Produto(1);
    //var_dump($produto->descricao);
    //print "Produto: ".$produto->descricao;
    // $produto->descricao = 'Cerveja';
    // $produto->estoque = 12;
    // $produto->preco_custo = 6;
    // $produto->preco_venda = 8;
    // $produto->codigo_barras ='879789799';
    // $produto->data_cadastro = date('Y-m-d');
    // $produto->origem = 'N';
    // $produto->store();

    Transaction::close();
} catch (Exception $e) {
    Transaction::rollback();
    print $e->getMessage();
}
