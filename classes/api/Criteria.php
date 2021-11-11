<?php

/**
 * Criteria [Patterns: Query Object]
 */
class Criteria
{
    private  $filters;
    public function __construct()
    {
        $this->filters = [];
    }
    public function add($variable, $compare, $value, $logic_op = 'and')
    {
        if (empty($this->filters)) {
            $logic_op = null;
        }
        $this->filters[] = [$variable, $compare, $this->transform($value), $logic_op];
    }
    public function transform($value)
    {
        
    }

    public function dump()
    {
        
    }
    
}