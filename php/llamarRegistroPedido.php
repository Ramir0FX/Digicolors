<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PEDIDO

$sql = "select peca.id_pedido_cabecera, id_cliente, id_funcionario, tiempo_recepcion, 
    tiempo_entrega, id_cond_venta, direccion, id_pedido_estado, peca.observacion, 
    id_pedido_detalle, id_producto, cantidad, precio, descuento 
    from pedido_cabecera peca, pedido_detalle pede 
    where peca.id_pedido_cabecera = pede.id_pedido_cabecera 
    and  peca.id_pedido_cabecera = $id";
$order_value = $conex->query($sql)->fetch(PDO::FETCH_UNIQUE);
$date = date_create($order_value['tiempo_entrega']);
$fecha_entrega = date_format($date, 'd-m-Y');
$hora_entrega = date_format($date, 'H:i:s');
$datos = array(
    0 => $order_value["id_pedido_cabecera"],
    1 => $order_value['id_cliente'],
    2 => $order_value['id_funcionario'],
    3 => $order_value['tiempo_recepcion'],
    4 => $fecha_entrega,
    5 => $hora_entrega,
    6 => $order_value['id_cond_venta'],
    7 => $order_value['direccion'],
    8 => $order_value['id_pedido_estado'],
    9 => $order_value['observacion'],
    10 => $order_value['id_producto'],
    11 => $order_value['cantidad'],
    12 => $order_value['precio'],
    13 => $order_value['descuento'],
    14 => $order_value['id_pedido_detalle']
);
echo json_encode($datos);
?>