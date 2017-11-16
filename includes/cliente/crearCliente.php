<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['C_CLIENTE_RUC_CI'])) && ($_POST['agregar_cliente'] == 1)) {
    $RUC_CI = $_POST['C_CLIENTE_RUC_CI'];
    $SQL_SELECT = 'select id_cliente from cliente where ruc_ci like :ruc_ci';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$RUC_CI]);
    $STMT->fetch(PDO::FETCH_ASSOC);
    $clienteEncontrado = $STMT->rowCount();
    if ($clienteEncontrado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El RUC/CI del cliente ya se encuentra en uso, intente nuevamente. 
                            </div>';
        return;
    }
    $NOMBRE = $_POST['C_CLIENTE_NOMBRE'];
    $APELLIDO = $_POST['C_CLIENTE_APELLIDO'];
    $RUC_ID = $_POST['C_CLIENTE_RUC_ID'];
    $DIRECCION = $_POST['C_CLIENTE_DIRECCION'];
    $EMAIL = $_POST['C_CLIENTE_EMAIL'];
    $PAGWEB = $_POST['C_CLIENTE_PAGWEB'];
    $ID_TIPO = $_POST['C_CLIENTE_ID_TIPO'];
    $ID_CATEGORIA = $_POST['C_CLIENTE_ID_CATEGORIA'];
    $TELEFONO = $_POST['C_CLIENTE_TELEFONO'];
    $OBSERVACION = $_POST['C_CLIENTE_OBSERVACION'];
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
    try {
        $stmt_cliente = $conex->prepare("insert into cliente(nombre, apellido, ruc_ci, ruc_identificador, direccion, email, pag_web, id_cliente_tipo, 
id_cliente_categoria, telefono, observacion) values (:nombre, :apellido, :ruc_ci, :ruc_identificador, :direccion, :email, :pag_web, :id_cliente_tipo, 
:id_cliente_categoria, :telefono, :observacion)");
        try {
            $conex->beginTransaction();
            $stmt_cliente->execute([$NOMBRE, $APELLIDO, $RUC_CI,
                $RUC_ID, $DIRECCION, $EMAIL, $PAGWEB, $ID_TIPO, $ID_CATEGORIA, $TELEFONO, $OBSERVACION]);
            $conex->commit();
            echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El cliente se cargó con éxito. 
                            </div>';
        } catch (PDOExecption $e) {
            $conex->rollback();
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al agregar el cliente, intente nuevamente. 
                            </div>';
        }
    } catch (PDOExecption $e) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al agregar el pedido, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>