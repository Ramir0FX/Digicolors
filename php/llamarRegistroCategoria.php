<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');


$id = $_POST['id'];
//OBTENEMOS LOS VALORES DE LA MARCA
$sql = "select id_producto_categoria, descripcion from producto_categoria where id_producto_categoria = $id";
$marca_value = $conex->query($sql)->fetch(PDO::FETCH_UNIQUE);
$datos = array(
    0 => $marca_value["id_producto_categoria"],
    1 => $marca_value['descripcion']
);
echo json_encode($datos);
?>