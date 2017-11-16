<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

try {
    $ID_FUNCIONARIO_ROL = $_SESSION['MS_USER_ROL_ID'];
    $ID_FUNCIONARIO = $_SESSION['MS_USER_ID'];
    $TIEMPO_ACTUAL = date('Y-m-d H:i:s');
    if ($ID_FUNCIONARIO_ROL == 1) {
        $SQL_SELECT = 'SELECT id_pedido_cabecera FROM pedido_cabecera WHERE id_pedido_estado = 1 AND tiempo_entrega < :tiempo_actual';
    } elseif ($ID_FUNCIONARIO_ROL == 2) {
        $SQL_SELECT = 'SELECT id_pedido_cabecera FROM pedido_cabecera WHERE id_pedido_estado = 1 AND tiempo_entrega < :tiempo_actual AND pedido_cabecera.id_funcionario = :id_funcionario';
    }
    $STMT = $conex->prepare($SQL_SELECT);
    if ($ID_FUNCIONARIO_ROL == 1) {
        $STMT->execute([$TIEMPO_ACTUAL]);
    } elseif ($ID_FUNCIONARIO_ROL == 2) {
        $STMT->execute([$TIEMPO_ACTUAL, $ID_FUNCIONARIO]);
    }
    $PRODUCTO = $STMT->fetch(PDO::FETCH_ASSOC);
    $pedidosAplazados = $STMT->rowCount();
    if ($pedidosAplazados == TRUE) {
        if ($ID_FUNCIONARIO_ROL == 1) {
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>ALERTA</strong> existe/n ' . $pedidosAplazados . ' pedido/s Aplazados' .
            '</div>';
        } elseif ($ID_FUNCIONARIO_ROL == 2) {
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>ALERTA</strong> tienes ' . $pedidosAplazados . ' pedido/s Aplazados' .
            '</div>';
        }

        //CAMBIAMOS EL ESTADO DE TODOS LOS PEDIDOS QUE SU FECHA DE ENTREGA SEA
        //SUPERIOR A LA FECHA DE RECEPCION
        //APLAZADO = 4
        $stmt_estado_pedido = $conex->prepare("UPDATE pedido_cabecera SET "
                . "id_pedido_estado = 4 "
                . "WHERE id_pedido_estado = 1 AND tiempo_entrega < :tiempo_actual");
        try {
            $conex->beginTransaction();
            $stmt_estado_pedido->execute([$TIEMPO_ACTUAL]);
            $conex->commit();
        } catch (PDOExecption $e) {
            $conex->rollback();
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar el pedido, intente nuevamente. 
                            </div>';
        }
    }
} catch (PDOExecption $e) {
    echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar el pedido, intente nuevamente. 
                            </div>';
}
?>