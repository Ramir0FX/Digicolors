<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['M_PEDIDO_ID'])) && ($_POST['modificar_pedido'] == 1)) {
    $PEDIDO_ID = $_POST['M_PEDIDO_ID'];
    $PEDIDO_ID_DETALLE = $_POST['M_PEDIDO_ID_DETALLE'];
    $PEDIDO_ID_CLIENTE = $_POST['M_PEDIDO_ID_CLIENTE'];
    $PEDIDO_ID_FUNCIONARIO = $_POST['M_PEDIDO_ID_FUNCIONARIO'];
    $PEDIDO_TIEMPO_RECEPCION = $_POST['M_PEDIDO_TIEMPO_RECEPCION'];
    //$PEDIDO_FECHA_ENTREGA = $_POST['M_PEDIDO_FECHA_ENTREGA'];
    $PEDIDO_FECHA_ENTREGA = date("Y-m-d", strtotime($_POST['M_PEDIDO_FECHA_ENTREGA']));
    $PEDIDO_HORA_ENTREGA = $_POST['M_PEDIDO_HORA_ENTREGA'];
    $PEDIDO_ID_COND_VENTA = 1;
    $PEDIDO_DIRECCION = $_POST['M_PEDIDO_DIRECCION'];
    $PEDIDO_ESTADO = $_POST['M_PEDIDO_ESTADO'];
    $PEDIDO_OBSERVACION = $_POST['M_PEDIDO_OBSERVACION'];
    $PEDIDO_ID_PRODUCTO = $_POST['M_PEDIDO_ID_PRODUCTO'];
    $PEDIDO_CANT = $_POST['M_PEDIDO_CANT'];
    $PEDIDO_PRECIO = $_POST['M_PEDIDO_PRECIO'];
    $PEDIDO_DESCUENTO = $_POST['M_PEDIDO_DESCUENTO'];

    //$date_entrega = date_create($PEDIDO_FECHA_ENTREGA . " " . $PEDIDO_HORA_ENTREGA);
    //$date_recepcion = date_create($PEDIDO_TIEMPO_RECEPCION);
    //VALIDAR FECHAS
    if (strtotime($PEDIDO_TIEMPO_RECEPCION) > strtotime($PEDIDO_FECHA_ENTREGA . " " . $PEDIDO_HORA_ENTREGA)) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La fecha de entrega debe ser mayor a la de recepción, intente nuevamente. 
                            </div>';
        return;
    }
    $PEDIDO_FECHA_ENTREGA = $PEDIDO_FECHA_ENTREGA . " " . $PEDIDO_HORA_ENTREGA;
    if (strlen($PEDIDO_DIRECCION) < 1) {
        $PEDIDO_DIRECCION = NULL;
    }
    if (strlen($PEDIDO_OBSERVACION) < 1) {
        $PEDIDO_OBSERVACION = NULL;
    }
    if (strlen($PEDIDO_DESCUENTO) < 1) {
        $PEDIDO_DESCUENTO = 0;
    }
    try {
        $stmt_cabecera = $conex->prepare("update pedido_cabecera set "
                . "id_cliente=:pedido_id_cliente,"
                . "id_funcionario=:pedido_id_funcionario,"
                //. "tiempo_recepcion=:pedido_tiempo_recepcion,"
                . "tiempo_entrega=:pedido_fecha_entrega,"
                . "id_cond_venta=:pedido_id_cond_venta,"
                . "direccion=:pedido_direccion,"
                . "id_pedido_estado=:pedido_estado,"
                . "observacion=:pedido_observacion "
                . "where id_pedido_cabecera=:pedido_id ");

        $stmt_detalle = $conex->prepare("update pedido_detalle set "
                . "id_producto=:pedido_id_producto,"
                . "cantidad=:pedido_cant,"
                . "precio=:pedido_precio,"
                . "descuento=:pedido_descuento "
                //. "observacion=[value-7] "
                . "where id_pedido_detalle=:pedido_id_detalle");
        try {
            $conex->beginTransaction();
            //UPDATE CABECERA
            $stmt_cabecera->execute([$PEDIDO_ID_CLIENTE, $PEDIDO_ID_FUNCIONARIO, $PEDIDO_FECHA_ENTREGA,
                $PEDIDO_ID_COND_VENTA, $PEDIDO_DIRECCION, $PEDIDO_ESTADO, $PEDIDO_OBSERVACION, $PEDIDO_ID]);
            //UPDATE DETALLE
            $stmt_detalle->execute([$PEDIDO_ID_PRODUCTO, $PEDIDO_CANT, $PEDIDO_PRECIO,
                $PEDIDO_DESCUENTO, $PEDIDO_ID_DETALLE]);
            $conex->commit();
            echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El pedido se modificó con éxito. 
                            </div>';
        } catch (PDOExecption $e) {
            $conex->rollback();
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar el pedido, intente nuevamente. 
                            </div>';
        }
    } catch (PDOExecption $e) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar el pedido, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>