<?php

/**
 * Criteria [Patterns: Query Object]
 * Define criterios para filtros de dados
 */
class Criteria
{
    
    /** @var array|null */
    private  $filters;

    /** @var array|null */
    private $proterties;

    public function __construct()
    {
        $this->filters = [];
        $this->proterties = [];
    }
    public function add($variable, $compare, $value, $logic_op = 'AND')
    {
        if (empty($this->filters)) {
            $logic_op = null;
        }
        $this->filters[] = [$variable, $compare, $this->transform($value), $logic_op];
    }    
    /**
     * transform
     *
     * @param  mixed $value
     * @return $result
     */
    public function transform($value)
    {
        if (is_array($value)) {
           foreach($value as $x){                
                if (is_integer($x)) {
                    $foo[] = $x;
                }else if (is_string($x)){
                    $foo[] = "'$x'";
                }
            }
            $result = '('.implode(', ', $foo).')';
        }else if(is_string($value)){
            $result = "'$value'";
        }
        else if (is_null($value)) {
            $result = 'NULL';
        }
        else if (is_bool($value)) {
            $result = $value ? 'TRUE' : 'FALSE';
        }else{
            $result = $value;
        }
        return $result;
    }

    public function dump()
    {
        if (is_array($this->filters) && count($this->filters) > 0) {
           $result = '';
           foreach ($this->filters as $filter) {
            $result .= $filter[3] .' '.$filter[0].' '.$filter[1].' '.$filter[2].' ';
           }
           $result = trim($result);
           return "({$result})";
        }
    }

    public function setProperty($property, $value)
    {
        $this->proterties[$property] = $value;
    }

    public function getProperty($property)
    {
        if (isset($this->proterties[$property])) {
            return $this->proterties[$property];
        }       
    }


    
}