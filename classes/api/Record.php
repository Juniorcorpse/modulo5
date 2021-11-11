<?php
abstract class Record
{
    /** @var array|null */
    protected $data;

    /** @var string $entity database table */
	protected $entity;
    
    /**
     * __construct
     *
     * @param  string $entity
     * @param  int|null $id
     */
    public function __construct(string $entity, ?int $id = null)
    {
        $this->entity = $entity;
        if ($id) {
            $obj = $this->load($id);
            if($obj){
                $this->fromArray($obj->toArray());
            }
        }
    }

    public function __set($name, $value)
	{
		if ($value === NULL) {
			unset($this->data[$name]);
		}

		$this->data[$name] = $value;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	/**
	 * @param $name
	 * @return null
	 */
	public function __get($name)
	{
		return $this->data[$name] ?? null;
	}

    public function __clone()
    {
        unset($this->data['id']);
    }

    public function fromArray(array $data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return $this->data;
    }

	/**
     * testar!!!!!!
	 * @return null|object
	 */
	public function data(): ?object
	{
        if (empty($this->data)) {
			$this->data = new \stdClass();
		}
		return (object) $this->data;
	}

    public function load(int $id, string $columns = '*')
    {
        $query = "SELECT {$columns} FROM {$this->entity} WHERE id={$id}";
        if($conn = Transaction::get()){
            Transaction::log($query);
            $result = $conn->query($query);
            if ($result) {
                return $result->fetchObject(static::class);
            }
        }else{
            throw new Exception("Error Processing Request, Não há transação ativa!");
            
        }
    }

    public static function find(int $id)
    {
       $className = get_called_class();
       $ar = new $className();
       return $ar->load($id);
    }
    
    /**
     * store
     *
     * 
     */
    public function store()
    {
        if (empty($this->data['id']) OR (!$this->load($this->data['id']))) {
            $prepared = $this->prepare($this->data);

            if (empty($this->date['id'])) {
                $this->data['id'] = $this->getLastId() + 1;
                $prepared['id'] = $this->data['id'];
            }

            $query = "INSERT INTO {$this->entity} ".
            '('.implode(',', array_keys($prepared)).')'.
            'values'.
            '('.implode(',', array_values($prepared)).')';
            if($conn = Transaction::get()){
                Transaction::log($query);
                $result = $conn->query($query);
            }else{
                throw new Exception("Error Processing Request, Não há transação ativa!");
                
            }
        }else {
            $prepared = $this->prepare($this->data);
        $set = [];
        foreach($prepared as $columns => $value){
            $set[] = "$columns = $value";
        }
        $query = "UPDATE {$this->entity}";
        $query.= " SET ".implode(', ', $set);
        $query.= "WHERE id=". (int) $this->data['id'];
        }
        if($conn = Transaction::get()){
            Transaction::log($query);
            $result = $conn->query($query);
        }else{
            throw new Exception("Error Processing Request, Não há transação ativa!");
            
        }
    }

   
    public function delete($id = null)
    {
        $id = $id ? $id : (int) $this->data['id'];

        if($conn = Transaction::get()){
            $query = "DELETE FROM {$this->entity} WHERE id={$id}";
            Transaction::log($query);
            $result = $conn->exec($query);
        }else{
            throw new Exception("Error Processing Request, Não há transação ativa!");
            
        }
    }
    public function getLastId()
    {
        if($conn = Transaction::get()){
            $query = "SELECT max(id) as max FROM {$this->entity} ";
            Transaction::log($query);
            $result = $conn->query($query);
            $row = $result->fetch();
            return $row->max;

        }else{
            throw new Exception("Error Processing Request, Não há transação ativa!");
            
        }
    }
    public function prepare(array $data)
    {
        $prepared = [];
        foreach($data as $key => $value){
            /**
             * [is_scalar]
             * Verifica se a dada variável é uma escalar.
             * Variáveis escalares são as que contém integer, float, string ou boolean.
             * os tipos array, object e resource não são escalares.
             */
            if (is_scalar($value)) {
                $prepared[$key] = $this->escape($value);
            }            
        }
        return $prepared;
    }

    protected function escape($value)
    {
        if (is_string($value) and (!empty($value)) ) {
            $value = filter_var($value, FILTER_DEFAULT);
            return "'$value'";
        }else if (is_bool($value)) {
            return $value ? 'TRUE' : 'FALSE';
        }else if ($value !== '') {
            return $value;
        }else {
            return "NULL";
        }
    }

}