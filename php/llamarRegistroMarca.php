<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

$id = $_POST['id'];
//OBTENEMOS LOS VALORES DE LA MARCA
$sql = "select id_marca, descripcion from marca where id_marca = $id";
$marca_value = $conex->query($sql)->fetch(PDO::FETCH_UNIQUE);
$datos = array(
    0 => $marca_value["id_marca"],
    1 => $marca_value['descripcion']
);
echo json_encode($datos);
?>