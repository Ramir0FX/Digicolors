<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['M_CLIENTE_ID'])) && ($_POST['modificar_cliente'] == 1)) {
    $ID_CLIENTE = $_POST['M_CLIENTE_ID'];
    $RUC_CI = $_POST['M_CLIENTE_RUC_CI'];
    $SQL_SELECT = 'select id_cliente from cliente where ruc_ci like :ruc_ci';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$RUC_CI]);
    $CLIENTE = $STMT->fetch(PDO::FETCH_ASSOC);
    $clienteEncontrado = $STMT->rowCount();
    if ($clienteEncontrado == TRUE) {
        $ID_NUEVO = $CLIENTE['id_cliente'];
        if ($ID_CLIENTE != $ID_NUEVO) {
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El R.U.C./C.I. del cliente ya se encuentra en uso, intente nuevamente. 
                            </div>';
            return;
        }
    }
    $NOMBRE = $_POST['M_CLIENTE_NOMBRE'];
    $APELLIDO = $_POST['M_CLIENTE_APELLIDO'];
    $RUC_ID = $_POST['M_CLIENTE_RUC_ID'];
    $DIRECCION = $_POST['M_CLIENTE_DIRECCION'];
    $EMAIL = $_POST['M_CLIENTE_EMAIL'];
    $PAGWEB = $_POST['M_CLIENTE_PAGWEB'];
    $ID_TIPO = $_POST['M_CLIENTE_ID_TIPO'];
    $ID_CATEGORIA = $_POST['M_CLIENTE_ID_CATEGORIA'];
    $TELEFONO = $_POST['M_CLIENTE_TELEFONO'];
    $OBSERVACION = $_POST['M_CLIENTE_OBSERVACION'];
    if (strlen($DIRECCION) < 1) {
        $DIRECCION = NULL;
    }
    if (strlen($EMAIL) < 1) {
        $EMAIL = NULL;
    }
    if (strlen($PAGWEB) < 1) {
        $PAGWEB = NULL;
    }
    if (strlen($TELEFONO) < 1) {
        $TELEFONO = NULL;
    }
    if (strlen($RUC_ID) < 1) {
        $RUC_ID = NULL;
    }
    if (strlen($OBSERVACION) < 1) {
        $OBSERVACION = NULL;
    }
    $SQL_UPDATE = "update cliente set nombre=:nombre, apellido=:apellido, "
            . "ruc_ci=:ruc_ci, ruc_identificador=:ruc_identificador, "
            . "direccion=:direccion, email=:email, "
            . "pag_web=:pag_web, id_cliente_tipo=:id_cliente_tipo, "
            . "id_cliente_categoria=:id_cliente_categoria, "
            . "telefono=:telefono,observacion=:observacion "
            . "where id_cliente=:id_cliente";
    $resultado = $conex->prepare($SQL_UPDATE)->execute([$NOMBRE, $APELLIDO, $RUC_CI,
        $RUC_ID, $DIRECCION, $EMAIL, $PAGWEB, $ID_TIPO,
        $ID_CATEGORIA, $TELEFONO, $OBSERVACION, $ID_CLIENTE]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El cliente se modificó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar el cliente, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>