<?php
class Produto
{
    /** @var object|null */
	protected $data;

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

    }  
    
    public static function all($filter = '')
    {
        
    }

    public function delete()
    {
        
    }

    public function save()
    {
        
    }

    public function getMargemLucro()
    {
        
    }

    public function registrarCompra()
    {
        
    }
}