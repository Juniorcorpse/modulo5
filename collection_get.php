<?php

require_once 'classes/api/Connection.php';
require_once 'classes/api/Transaction.php';
require_once 'classes/api/Criteria.php';
require_once 'classes/api/Repository.php';
require_once 'classes/api/Record.php';
require_once 'classes/api/Logger.php';
require_once 'classes/api/LoggerTXT.php';
require_once 'classes/model/Produto.php';

try {
    Transaction::open('estoque');
    Transaction::setLogger(new LoggerTXT('log.txt'));

    $criteria = new Criteria;
    $criteria->add('estoque', '>', 10);
    $criteria->add('origem', '=', 'N');

    $repository = new Repository('Produto');
    $podutos = $repository->load($criteria);
    if ($podutos) {
        foreach($podutos as $poduto){
            print 'ID: '. $poduto->id;
            print ' - descircao:  '. $poduto->descricao;
            print ' - estoque: '. $poduto->estoque;
            print '<br/> ';
        }
        print 'Quantidade: '.$repository->count($criteria);
    }

    Transaction::close();
} catch (\PDOException $pdoex) {    
    print $pdoex->getMessage();
    Transaction::rollback();
}