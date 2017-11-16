<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['P_PEDIDO_ID'])) && ($_POST['entregar_pedido'] == 1)) {
    $PEDIDO_ID = $_POST['P_PEDIDO_ID'];
    try {
        $stmt_cabecera = $conex->prepare("UPDATE pedido_cabecera SET "
                . "id_pedido_estado = 2 "
                . "WHERE id_pedido_cabecera = :pedido_id ");
        try {
            $conex->beginTransaction();
            $stmt_cabecera->execute([$PEDIDO_ID]);
            $conex->commit();
            echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El pedido se entregó con éxito. 
                            </div>';
        } catch (PDOExecption $e) {
            $conex->rollback();
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al entregar el pedido, intente nuevamente. 
                            </div>';
        }
    } catch (PDOExecption $e) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al entregar el pedido, intente nuevamente. 
                            </div>';
    }
} else {
    header("Location:../../index.php");
}
?>