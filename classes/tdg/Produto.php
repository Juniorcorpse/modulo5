<?php
class Produto
{
    /** @var object|null */
	protected $data;

    public static function setConnection(PDO $conn)
    {
        ProdutoGateway::setConnection($conn);
    }

    /**
	 * @param $name
	 * @return null
	 */
	public function __get($name)
	{
		return ($this->data->$name ?? null);
	}

    /**
	 * @param $name
	 * @param $value
	 */
	public function __set($name, $value)
	{
		if (empty($this->data)) {
			$this->data = new \stdClass();
		}

		$this->data->$name = $value;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->data->$name);
	}

	/**
	 * @return null|object
	 */
	public function data(): ?object
	{
		return $this->data;
	}

    public static function find($id)
    {
        $gw = new ProdutoGateway;
        return $gw->find($id, __CLASS__);

    }  
        
    /**
     * all
     *
     * @param  mixed $filter
     * @return void
     */
    public static function all($filter = '')
    {
        $gw = new ProdutoGateway;
        return $gw->all($filter, __CLASS__);        
    }
    
    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $gw = new ProdutoGateway;
        return $gw->delete($this->id);
    }
    
    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        $gw = new ProdutoGateway;
        return $gw->save($this->data());        
    }
    
    /**
     * getMargemLucro
     *
     * @return void
     */
    public function getMargemLucro()
    {
       return (($this->preco_venda - $this->preco_custo) / $this->preco_custo) * 100;
    }
    
    /**
     * registrarCompra
     *
     * @param  mixed $custo
     * @param  mixed $qantidade
     * @return void
     */
    public function registrarCompra($custo, $qantidade)
    {
        $this->preco_custo = $custo;
        $this->estoque += $qantidade;
    }
}