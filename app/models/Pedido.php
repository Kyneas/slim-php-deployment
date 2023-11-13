<?php
class Pedido
{
    public $id;
    public $productos = array();
    public $idMesa;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (productos, idMesa) VALUES (:productos, :idMesa)");
        $consulta->bindValue(':productos', $this->productos, PDO::PARAM_STR);
        $consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, productos, idMesa FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($producto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, pedidos, idMesa FROM pedidos WHERE id = :id");
        $consulta->bindValue(':producto', $producto, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($producto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET pedidos = :pedidos WHERE id = :id");
        $consulta->bindValue(':capacidad', $producto->capacidad, PDO::PARAM_INT);
        $consulta->bindValue(':id', $producto->_id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarPedido($producto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $producto, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }
}
