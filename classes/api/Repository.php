<?php
class Repository
{
    private $activeRecord;

    public function __construct($class)
    {
        $this->activeRecord = $class;
    }
    public function load(Criteria $criteria)
    {
        $sql = "SELECT * FROM ". $this->entity;

        if ($criteria) {
            $expression = $criteria->dump();
            if ($expression) {
                $sql .= 'WHERE '. $expression;
            }
            $order = $criteria->getProperty('ORDER');
            $limit = $criteria->getProperty('LIMIT');
            $offset = $criteria->getProperty('OFFSET');
        }
    }

    public function delete(Criteria $criteria)
    {
        
    }
    public function count(Criteria $criteria)
    {
        
    }
}