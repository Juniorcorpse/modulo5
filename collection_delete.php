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
    Transaction::setLogger(new LoggerTXT('log_delete.txt'));

    $criteria = new Criteria();
    $criteria->add('descricao', 'like', '%WEBC%');
    $criteria->add('descricao', 'like', '%FILMAD%', 'OR');

    $repository = new Repository('Produto');
    $repository->delete($criteria);

    Transaction::close();
} catch (\PDOException $pdoex) {    
    print $pdoex->getMessage();
    Transaction::rollback();
}