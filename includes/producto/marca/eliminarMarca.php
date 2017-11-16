<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['E_MARCA_ID'])) && ($_POST['eliminar_marca'] == 1)) {

    $ID_MARCA = $_POST['E_MARCA_ID'];
    $SQL_SELECT = 'select prod.id_marca from producto prod, marca m '
            . 'where prod.id_marca = m.id_marca '
            . 'and prod.id_marca = :id_marca';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$ID_MARCA]);
    $CATEGORIA = $STMT->fetch(PDO::FETCH_ASSOC);
    $productoEncontrado = $STMT->rowCount();
    if ($productoEncontrado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Existen productos que se encuentran utilizando esa marca, no es posible eliminar. 
                        </div>';
        return;
    }
    $SQL_DELETE = "delete from marca where id_marca = :id_marca";
    $resultado = $conex->prepare($SQL_DELETE)->execute([$ID_MARCA]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                La marca se eliminó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al eliminar la marca, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>