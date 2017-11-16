<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['C_PEDIDO_ID_CLIENTE'])) && ($_POST['agregar_pedido'] == 1)) {
    //DATOS CABECERA
    $ID_CLIENTE = $_POST['C_PEDIDO_ID_CLIENTE'];
    $ID_FUNCIONARIO = $_POST['C_PEDIDO_ID_FUNCIONARIO'];
    $TIEMPO_RECEPCION = date('Y-m-d H:i:s');
    $date = date_create($_POST['C_PEDIDO_FECHA_ENTREGA'] . " " . $_POST['C_PEDIDO_HORA_ENTREGA'] . ":00");
    $TIEMPO_ENTREGA = date_format($date, 'Y-m-d H:i:s');
    $ID_COND_VENTA = 1;
    $DIRECCION = $_POST['C_PEDIDO_DIRECCION'];
    $ID_PEDIDO_ESTADO = 1;
    $OBSERVACION_CABECERA = $_POST['C_PEDIDO_OBSERVACION_CABECERA'];
    //DATOS DETALLE
    $ID_PRODUCTO = $_POST['C_PEDIDO_ID_PRODUCTO'];
    $CANTIDAD = $_POST['C_PEDIDO_CANT'];
    $PRECIO = $_POST['C_PEDIDO_PRECIO'];
    $DESCUENTO = $_POST['C_PEDIDO_DESCUENTO'];

    //VALIDAR FECHAS
    if (strtotime($TIEMPO_RECEPCION . "") >= strtotime($TIEMPO_ENTREGA . "")) {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La fecha de entrega debe ser mayor a la de recepción, intente nuevamente. 
                            </div>';
        return;
    }
    if (strlen($DIRECCION) < 1) {
        $DIRECCION = NULL;
    }
    if (strlen($OBSERVACION_CABECERA) < 1) {
        $OBSERVACION_CABECERA = NULL;
    }
    if (strlen($DESCUENTO) < 1) {
        $DESCUENTO = 0;
    }
    try {
        $stmt_cabecera = $conex->prepare("insert into pedido_cabecera( 
        id_cliente, id_funcionario, tiempo_recepcion, 
        tiempo_entrega, id_cond_venta, direccion, id_pedido_estado, observacion) 
        values (:id_cliente, :id_funcionario, :tiempo_recepcion, 
        :tiempo_entrega, :id_cond_venta, :direccion, :id_pedido_estado, :observacion_cabecera)");

        $stmt_detalle = $conex->prepare("insert into pedido_detalle( 
            id_pedido_cabecera, id_producto, cantidad, precio, descuento) 
            values (:id_pedido_cabecera, :id_producto, :cantidad, 
            :precio, :descuento)");
        try {
            $conex->beginTransaction();
            //INSERTAR CABECERA
            $stmt_cabecera->execute([$ID_CLIENTE, $ID_FUNCIONARIO, $TIEMPO_RECEPCION,
                $TIEMPO_ENTREGA, $ID_COND_VENTA, $DIRECCION, $ID_PEDIDO_ESTADO, $OBSERVACION_CABECERA]);
            //OBTENEMOS SU ID
            $ID_PEDIDO_CABECERA = $conex->lastInsertId();
            //INSERTAR DETALLE
            $stmt_detalle->execute([$ID_PEDIDO_CABECERA, $ID_PRODUCTO, $CANTIDAD,
                $PRECIO, $DESCUENTO]);
            $conex->commit();
            echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El pedido se cargó con éxito. 
                            </div>';
        } catch (PDOExecption $e) {
            $conex->rollback();
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al agregar el pedido, intente nuevamente. 
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