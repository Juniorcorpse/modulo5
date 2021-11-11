<?php

class Produto extends Record
{
    public function __construct(?int $id = null)
    {
        parent::__construct("produto", $id);
    }
}