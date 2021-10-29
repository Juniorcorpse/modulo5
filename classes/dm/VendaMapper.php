<?php
/**
 * VendaMapper  [Data Mapper]
 */
class VendaMapper
{

     /** @var \PDO */
     private static $conn;

     /**
     * setConnection
     *
     * @param  mixed $conn
     * @return void
     */
    public static function setConnection(PDO $conn)
    {
        self::$conn = $conn;
    }
    
    /**
     * save
     *
     * @param  Venda $venda
     * @return void
     */
    public static function save(Venda $venda)
    {
        $data = date('Y-m-d');
        $sql = "INSERT INTO venda (data_venda) values ('{$data}')";
        print $sql."<br/>";
        self::$conn->query($sql);

        $id =  self::getLastId();     
        $venda->setId($id);   


        foreach($venda->getItens() as $item){
            $quantidade = $item[0];

            //recebe o obj Produto
            $produto = $item[1];
            $preco = $produto->preco;
            $sql = "INSERT INTO item_venda (id_venda, id_produto, quantidade, preco) values ('{$id}', '{$produto->id}', '{$quantidade}', '{$preco}')";
            print $sql."<br/>";
            self::$conn->query($sql);


        }
    }
    
    /**
     * getLastId
     *
     * @return void
     */
    public static function getLastId()
    {
        $sql = "SELECT max(id) as max FROM venda";
        $result = self::$conn->query($sql);
        $data = $result->fetchObject();
        return $data->max;
    }

}