<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

$ROL_USUARIO= $_SESSION['MS_USER_ROL_NAME'];
$tabla = "";

//pedido_estado pendiente=1
//pedido_estado aplazado=4
$sql = "select peca.id_pedido_cabecera \"id\", (select concat(cliente.nombre,' ',cliente.apellido) from cliente where cliente.id_cliente = peca.id_cliente)\"cliente\", (select concat(funcionario.nombre,' ',funcionario.apellido) from funcionario where funcionario.id_funcionario = peca.id_funcionario)\"funcionario\", `tiempo_recepcion`, `tiempo_entrega`, (select pedido_estado.descripcion from pedido_estado where pedido_estado.id_pedido_estado = peca.id_pedido_estado)\"estado\", "
        . "(select prod.nombre from producto prod where prod.id_producto = pede.id_producto) \"producto\""
        . "from pedido_cabecera peca, pedido_detalle pede "
        . "where peca.id_pedido_cabecera = pede.id_pedido_cabecera "
        . "and peca.id_pedido_estado in(1,4)";

$job_list = $conex->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$total_row_jobs = count($job_list);
$tabla = $tabla . '<table class="table table-hover mb-none">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Producto/Servicio</th>
                        <th>Funcionario</th>
                        <th>Tiempo recepción</th>
                        <th>Tiempo entrega</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>';
foreach ($job_list as $row => $link) {
    $tabla = $tabla . '<tr class="odd gradeX">
    <td> ' . $link['id'] . ' </td>
    <td> ' . $link['cliente'] . ' </td>
    <td> ' . $link['producto'] . ' </td>
    <td> ' . $link['funcionario'] . '</td>
    <td>' . strftime('%d/%b/%y %H:%M', strtotime($link['tiempo_recepcion'])) . '</td>
    <td>' . strftime('%d/%b/%y %H:%M', strtotime($link['tiempo_entrega'])) . '</td>';

    if ($link['estado'] == 'Pendiente') {
        $tabla = $tabla . '<td> <span class="badge badge-info verde">' . $link['estado'] . '</span></td>';
    } elseif ($link['estado'] == 'Entregado') {
        $tabla = $tabla . '<td> <span class="badge badge-info">' . $link['estado'] . '</span></td>';
    } elseif ($link['estado'] == 'Cancelado') {
        $tabla = $tabla . '<td> <span class="badge badge-info naranja">' . $link['estado'] . '</span></td>';
    } elseif ($link['estado'] == 'Aplazado') {
        $tabla = $tabla . '<td> <span class="badge badge-info rojo">' . $link['estado'] . '</span></td>';
    }
    if ($ROL_USUARIO == "Administrador") {
        $tabla = $tabla . '<td class="center">
		<a href="javascript:llamarFormularioEntregarPedido(' . $link['id'] . ');" title="Entregar pedido" class="mb-1 mt-1 mr-1 btn btn-info"><i class="fa fa-thumbs-up"></i> </a>
        <a href="javascript:llamarFormularioEditarPedido(' . $link['id'] . ');" title="Editar pedido" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
        <a href="javascript:llamarFormularioEliminarPedido(' . $link['id'] . ');" title="Eliminar pedido" class="btn btn-danger"> <i class="fa fa-trash-o"></i> </a>
    </td>
</tr>';
    } elseif ($ROL_USUARIO == "Funcionario") {
        $tabla = $tabla . '<td class="center">
		<a href="javascript:llamarFormularioEntregarPedido(' . $link['id'] . ');" title="Entregar pedido" class="mb-1 mt-1 mr-1 btn btn-info"><i class="fa fa-thumbs-up"></i> </a>
		</td>
</tr>';
    }
}

$tabla = $tabla . '</table>';
$array = array(0 => $tabla);
echo json_encode($array);
?>