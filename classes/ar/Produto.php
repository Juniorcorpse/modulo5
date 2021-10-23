<?php
class Produto
{
    /** @var object|null */
	protected $data;

    /** @var \PDO */
    private static $conn;

    public static function setConnection(PDO $conn)
    {
        self::$conn = $conn;
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
        $sql = "SELECT * FROM produto WHERE id= '$id' ";
        print "$sql <br/>";
        $result = self::$conn->query($sql);
        return $result->fetchObject(__CLASS__);
    }  
        
    /**
     * all
     *
     * @param  mixed $filter
     * @return void
     */
    public static function all($filter = '')
    {
        $sql = "SELECT * FROM produto ";

        if($filter){
            $sql .= "WHERE $filter ";
        }
        print "$sql <br/>";
        $result = self::$conn->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }
    
    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $sql = "DELETE FROM produto WHERE id= '{$this->id}' ";
        print "$sql <br/>";
        return self::$conn->query($sql);
    }
    
    /**
     * save
     *
     * @return void
     */
    public function save()
    {
        if (empty($this->data()->id)) {
            $id = $this->getLastId() +1;
            $sql = "INSERT INTO produto (id, descricao, estoque, preco_custo, ".
                                   "      preco_venda, codigo_barras, data_cadastro, origem)" .
                                   " VALUES ('{$id}', " .
                                            "'{$this->descricao}', " .
                                            "'{$this->estoque}', " .
                                            "'{$this->preco_custo}', " .
                                            "'{$this->preco_venda}', " .
                                            "'{$this->codigo_barras}', " .
                                            "'{$this->data_cadastro}', " .
                                            "'{$this->origem}')";
        }
        else {
            $sql = "UPDATE produto SET descricao     = '{$this->descricao}', " .
                                "       estoque       = '{$this->estoque}', " .
                                "       preco_custo   = '{$this->preco_custo}', " .
                                "       preco_venda   = '{$this->preco_venda}', ".
                                "       codigo_barras = '{$this->codigo_barras}', ".
                                "       data_cadastro = '{$this->data_cadastro}', ".
                                "       origem        = '{$this->origem}' ".
                                "WHERE  id            = '{$this->id}'";
        }
        print "$sql <br>";
        return self::$conn->exec($sql);
    }
    
    /**
     * getLastId
     *
     * @return int $data->max
     */
    public function getLastId()
    {
        $sql = "SELECT max(id) as max FROM produto";
        $result = self::$conn->query($sql);
        $data = $result->fetchObject();
        return $data->max;
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