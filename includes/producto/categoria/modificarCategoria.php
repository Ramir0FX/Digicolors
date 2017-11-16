<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['M_CATEGORIA_ID'])) && ($_POST['modificar_categoria'] == 1)) {

    $ID_CATEGORIA = $_POST['M_CATEGORIA_ID'];
    $DESCRIPCION = $_POST['M_CATEGORIA_NOMBRE'];
    $SQL_SELECT = 'select id_producto_categoria, descripcion from producto_categoria where descripcion like :descripcion';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$DESCRIPCION]);
    $CATEGORIA = $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        $ID_NUEVO = $CATEGORIA['id_producto_categoria'];
        if ($ID_CATEGORIA != $ID_NUEVO) {
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El nombre de la categoría ya se encuentra en uso, intente nuevamente. 
                            </div>';
            return;
        }
    }

    if (strlen($DESCRIPCION) < 1) {
        $DESCRIPCION = NULL;
        return;
    }
    $SQL_UPDATE = "update producto_categoria set
            descripcion = :descripcion where id_producto_categoria = :id_categoria";
    $resultado = $conex->prepare($SQL_UPDATE)->execute([$DESCRIPCION, $ID_CATEGORIA]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La categoría se modificó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar la categoría, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>