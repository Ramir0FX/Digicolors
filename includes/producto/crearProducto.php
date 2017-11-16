<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['C_NOMBRE'])) && ($_POST['agregar_producto'] == 1)) {

    $NOMBRE = $_POST['C_NOMBRE'];
    $SQL_SELECT = 'select nombre from producto where nombre like :nombre';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$NOMBRE]);
    $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El nombre del producto ya se encuentra en uso, intente nuevamente. 
                            </div>';
        return;
    }
    $DESCRIPCION = $_POST['C_DESCRIPCION'];
    $PRECIO_COSTO = $_POST['C_PRECIO_COSTO'];
    $PRECIO_VENTA = $_POST['C_PRECIO_VENTA'];
    $ID_MARCA = $_POST['C_ID_MARCA'];
    $ID_IMPUESTO = $_POST['C_ID_IMPUESTO'];
    $ID_PRODUCTO_ESTADO = 1;
    $ID_PRODUCTO_CATEGORIA = $_POST['C_ID_CATEGORIA'];
    $CANT_ACTUAL = $_POST['C_CANT_ACTUAL'];

    if (strlen($NOMBRE) < 1) {
        $NOMBRE = NULL;
    }
    if (strlen($CANT_ACTUAL) < 1) {
        $CANT_ACTUAL = NULL;
    }
    $SQL_INSERT = "insert into 
            producto(
            nombre, descripcion, id_producto_estado, id_marca, id_impuesto, 
            id_producto_categoria, precio_costo, precio_venta, cant_actual)
            values 
            (:nombre, :descripcion, :id_producto_estado, :id_marca, :id_impuesto, 
            :id_producto_categoria, :precio_costo, :precio_venta, :cant_actual)";
    $resultado = $conex->prepare($SQL_INSERT)->execute([$NOMBRE, $DESCRIPCION, $ID_PRODUCTO_ESTADO, $ID_MARCA, $ID_IMPUESTO,
        $ID_PRODUCTO_CATEGORIA, $PRECIO_COSTO, $PRECIO_VENTA, $CANT_ACTUAL]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El producto se inserto exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al agregar producto, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>