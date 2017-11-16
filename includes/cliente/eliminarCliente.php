<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

if ((isset($_POST['E_CLIENTE_ID'])) && ($_POST['eliminar_cliente'] == 1)) {

    $ID_CLIENTE = $_POST['E_CLIENTE_ID'];
    $SQL_SELECT = 'select peca.id_cliente from pedido_cabecera peca, cliente clie '
            . 'where peca.id_cliente = clie.id_cliente '
            . 'and clie.id_cliente = :id_cliente';
    $STMT = $conex->prepare($SQL_SELECT);
    $STMT->execute([$ID_CLIENTE]);
    $CLIENTE = $STMT->fetch(PDO::FETCH_ASSOC);
    $clienteEncontrado = $STMT->rowCount();
    if ($clienteEncontrado == TRUE) {
        echo '<div id="mensaje" class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Existen pedidos que se encuentran utilizando ese cliente, no es posible eliminar. 
                        </div>';
        return;
    }
    $SQL_DELETE = "delete from cliente where id_cliente = :id_cliente";
    $resultado = $conex->prepare($SQL_DELETE)->execute([$ID_CLIENTE]);

    if ($resultado == TRUE) {
        echo'<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                El cliente se eliminó exitosamente. 
                            </div>';
    } else {
        echo '<div id="mensaje" class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Hubo un problema al eliminar el cliente, intente nuevamente. 
                            </div>';
    }
} else {
    header('Location:' . root . 'index.php');
}
?>