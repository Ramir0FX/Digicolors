<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['E_PRODUCTO_ID'])) && ($_POST['eliminar_producto'] == 1)) {

    $ID_PRODUCTO = $_POST['E_PRODUCTO_ID'];
    $SQL_SELECT = 'select pede.id_pedido_detalle from pedido_detalle pede, producto prod '
            . 'where pede.id_producto = prod.id_producto '
            . 'and prod.id_producto = :id_producto';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$ID_PRODUCTO]);
    $PRODUCTO = $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Existen pedidos que se encuentran utilizando ese producto, no es posible eliminar. 
                        </div>';
        return;
    }
    $SQL_DELETE = "delete from producto where id_producto = :id_producto";
    $resultado = $conex->prepare($SQL_DELETE)->execute([$ID_PRODUCTO]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El producto se eliminó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al eliminar el producto, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>