<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['M_MARCA_ID'])) && ($_POST['modificar_marca'] == 1)) {

    $ID_MARCA = $_POST['M_MARCA_ID'];
    $DESCRIPCION = $_POST['M_MARCA_NOMBRE'];
    $SQL_SELECT = 'select id_marca, descripcion from marca where descripcion like :descripcion';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$DESCRIPCION]);
    $MARCA = $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        $ID_NUEVO = $MARCA['id_marca'];
        if ($ID_MARCA != $ID_NUEVO) {
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El nombre de la marca ya se encuentra en uso, intente nuevamente. 
                            </div>';
            return;
        }
    }

    if (strlen($DESCRIPCION) < 1) {
        $DESCRIPCION = NULL;
        return;
    }
    $SQL_UPDATE = "update marca set
            descripcion = :descripcion where id_marca = :id_marca";
    $resultado = $conex->prepare($SQL_UPDATE)->execute([$DESCRIPCION, $ID_MARCA]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La marca se modificó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar la marca, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>