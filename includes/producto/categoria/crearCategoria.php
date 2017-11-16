<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['C_CATEGORIA_NOMBRE'])) && ($_POST['agregar_categoria'] == 1)) {

    $NOMBRE = $_POST['C_CATEGORIA_NOMBRE'];
    $SQL_SELECT = 'select descripcion from producto_categoria where descripcion like :nombre';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$NOMBRE]);
    $STMT->fetch(PDO::FETCH_ASSOC);
    $categoriaEncontrada = $STMT->rowCount();
    if ($categoriaEncontrada == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El nombre de la categoría ya se encuentra en uso, intente nuevamente. 
                            </div>';
        return;
    }
    if (strlen($NOMBRE) < 1) {
        return;
    }
    $SQL_INSERT = "insert into 
            producto_categoria(
            descripcion)
            values 
            (:nombre)";
    $resultado = $conex->prepare($SQL_INSERT)->execute([$NOMBRE]);

    if ($resultado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La categoría se insertó con éxito. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al agregar la categoría, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>