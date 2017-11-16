<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['E_PEDIDO_ID']))) {

    $ID_PEDIDO = $_POST['E_PEDIDO_ID'];
    $SQL_DELETE = "delete from pedido_cabecera where id_pedido_cabecera = :id_pedido";
    $resultado = $conex->prepare($SQL_DELETE)->execute([$ID_PEDIDO]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El pedido se eliminó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al eliminar el pedido, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>