<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['M_ID'])) && ($_POST['modificar_producto'] == 1)) {

    $ID_PRODUCTO = $_POST['M_ID'];
    $NOMBRE = $_POST['M_NOMBRE'];
    $SQL_SELECT = 'select id_producto, nombre from producto where nombre like :nombre';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$NOMBRE]);
    $PRODUCTO = $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        $ID_NUEVO = $PRODUCTO['id_producto'];
        if ($ID_PRODUCTO != $ID_NUEVO) {
            echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El nombre del producto ya se encuentra en uso, intente nuevamente. 
                            </div>';
            return;
        }
    }
    $DESCRIPCION = $_POST['M_DESCRIPCION'];
    $PRECIO_COSTO = $_POST['M_PRECIO_COSTO'];
    $PRECIO_VENTA = $_POST['M_PRECIO_VENTA'];
    $ID_MARCA = $_POST['M_ID_MARCA'];
    $ID_IMPUESTO = $_POST['M_ID_IMPUESTO'];
    $ID_PRODUCTO_ESTADO = $_POST['M_ID_ESTADO'];
    $ID_PRODUCTO_CATEGORIA = $_POST['M_ID_CATEGORIA'];
    $CANT_ACTUAL = $_POST['M_CANT_ACTUAL'];

    if (strlen($NOMBRE) < 1) {
        $NOMBRE = NULL;
    }
    if (strlen($CANT_ACTUAL) < 1) {
        $CANT_ACTUAL = NULL;
    }
    $SQL_UPDATE = "update producto set
            nombre = :nombre, descripcion = :descripcion, id_producto_estado = :id_producto_estado,
            id_marca = :id_marca, id_impuesto = :id_impuesto, 
            id_producto_categoria = :id_producto_categoria, precio_costo = :precio_costo, 
            precio_venta = :precio_venta, 
            cant_actual = :cant_actual where id_producto = :id_producto";
    $resultado = $conex->prepare($SQL_UPDATE)->execute([$NOMBRE, $DESCRIPCION, $ID_PRODUCTO_ESTADO,
        $ID_MARCA, $ID_IMPUESTO, $ID_PRODUCTO_CATEGORIA, $PRECIO_COSTO, $PRECIO_VENTA,
        $CANT_ACTUAL, $ID_PRODUCTO]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El producto se modificó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al modificar producto, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>