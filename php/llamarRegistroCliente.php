<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
$id = $_POST['id'];

//OBTENEMOS LOS VALORES DEL PRODUCTO

$sql = "select id_cliente, nombre, apellido, ruc_ci, ruc_identificador, "
        . "direccion, email, pag_web, id_cliente_tipo, id_cliente_categoria, "
        . "telefono, observacion from cliente where id_cliente = $id";
$customer_value = $conex->query($sql)->fetch(PDO::FETCH_UNIQUE);

$datos = array(
    0 => $customer_value["id_cliente"],
    1 => $customer_value['nombre'],
    2 => $customer_value['apellido'],
    3 => $customer_value['ruc_ci'],
    4 => $customer_value['ruc_identificador'],
    5 => $customer_value['telefono'],
    6 => $customer_value['id_cliente_categoria'],
    7 => $customer_value['id_cliente_tipo'],
    8 => $customer_value['email'],
    9 => $customer_value['pag_web'],
    10 => $customer_value['direccion'],
    11 => $customer_value['observacion']
);
echo json_encode($datos);
?>