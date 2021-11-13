<?php

class Produto extends Record
{
    const TABLENAME = 'produto';
    public function __construct(?int $id = null)
    {
        parent::__construct("produto", $id);
    }
}