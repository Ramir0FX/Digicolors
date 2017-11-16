<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$sql = "select id_producto, nombre, descripcion, precio_costo, "
        . "precio_venta, id_marca,id_impuesto, "
        . "id_producto_estado, id_producto_categoria, cant_actual "
        . "from producto where id_producto = $id";
$product_value = $conex->query($sql)->fetch(PDO::FETCH_UNIQUE);

$datos = array(
    0 => $product_value["id_producto"],
    1 => $product_value['nombre'],
    2 => $product_value['descripcion'],
    3 => $product_value['precio_costo'],
    4 => $product_value['precio_venta'],
    5 => $product_value['id_producto_estado'],
    6 => $product_value['id_producto_categoria'],
    7 => $product_value['id_impuesto'],
    8 => $product_value['id_marca'],
    9 => $product_value['cant_actual']
);
echo json_encode($datos);
?>