<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['E_CATEGORIA_ID'])) && ($_POST['eliminar_categoria'] == 1)) {

    $ID_CATEGORIA = $_POST['E_CATEGORIA_ID'];
    $SQL_SELECT = 'select prod.id_producto from producto prod, producto_categoria prca '
            . 'where prod.id_producto_categoria = prca.id_producto_categoria '
            . 'and prod.id_producto_categoria = :id_categoria';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$ID_CATEGORIA]);
    $CATEGORIA = $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Existen productos que se encuentran utilizando esa categoría, no es posible eliminar. 
                        </div>';
        return;
    }
    $SQL_DELETE = "delete from producto_categoria where id_producto_categoria = :id_categoria";
    $resultado = $conex->prepare($SQL_DELETE)->execute([$ID_CATEGORIA]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La categoría se eliminó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al eliminar la categoría, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>