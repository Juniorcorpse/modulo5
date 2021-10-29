<?php

/**
 * Venda
 */
class Venda
{
    private $id;
    private $itens;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
    
    /**
     * addItem
     *
     * @param  mixed $quantidade
     * @param  Produto $produto
     * @return void
     */
    public function addItem($quantidade, Produto $produto)
    {
        $this->itens[] = [$quantidade, $produto];
    }
    
    /**
     * getItens
     *
     * @return $this->itens
     */
    public function getItens()
    {
        return $this->itens;
    }
}