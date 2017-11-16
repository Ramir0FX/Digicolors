<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
$ROL_USUARIO = $_SESSION['MS_USER_ROL_NAME'];

$tabla = "";

$sql_customers = "select id_cliente, concat(nombre,' ',apellido)\"nombre\", ruc_ci, ruc_identificador, "
        . "(select descripcion from cliente_tipo where cliente_tipo.id_cliente_tipo = cliente.id_cliente_tipo)\"tipo\", "
        . "(select descripcion from cliente_categoria where cliente_categoria.id_cliente_categoria = cliente.id_cliente_categoria)\"categoria\", "
        . "telefono, email , pag_web, direccion, observacion from cliente";
$customer_list = $conex->query($sql_customers)->fetchAll(PDO::FETCH_ASSOC);
$total_row_customer = count($sql_customers);

$tabla = $tabla . '<table class="table table-hover mb-none">
			            <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>RUC/CI</th>
                                            <th>Telefono</th>
                                            <th>Tipo</th>
                                            <th>Categoría</th>
                                            <th>E-mail</th>
                                            <th>Pag. web</th>
                                            <th>Direccion</th>
                                            <th>Observación</th>
                                            <th>Acciones</th>
                                        </tr>';
foreach ($customer_list as $row => $link) {
    $tabla = $tabla . '<tr class="odd gradeX">                            <td> ' . $link['id_cliente'] . ' </td>                            <td> ' . $link['nombre'] . ' </td>';
    if ($link['ruc_identificador'] == NULL) {
        $tabla = $tabla . '<td> ' . $link['ruc_ci'] . ' </td>';
    } else {
        $tabla = $tabla . '<td> ' . $link['ruc_ci'] . '-' . $link['ruc_identificador'] . ' </td>';
    } $tabla = $tabla . '<td> ' . $link['telefono'] . ' </td>                            <td> ' . $link['tipo'] . ' </td>                            <td> ' . $link['categoria'] . ' </td>                            <td> ' . $link['email'] . ' </td>                            <td> ' . $link['pag_web'] . ' </td>                            <td> ' . $link['direccion'] . ' </td>                            <td> ' . $link['observacion'] . ' </td>';
    if ($ROL_USUARIO == "Administrador") {
        $tabla = $tabla . '<td class="center">        '
                . '<a href="javascript:llamarFormularioEditarCliente(' . $link['id_cliente'] . ');" title="Editar cliente" class="btn btn-warning"><i class="fa fa-pencil"></i></a>        '
                . '<a href="javascript:llamarFormularioEliminarCliente(' . $link['id_cliente'] . ');" title="Eliminar cliente" class="btn btn-danger"> <i class="fa fa-trash-o"></i> </a>'
                . '    </td></tr>';
    } elseif ($ROL_USUARIO == "Funcionario") {
        $tabla = $tabla . '<td> Sin acciones </td></tr>';
    }
}$tabla = $tabla . '</table>';
$array = array(0 => $tabla);
echo json_encode($array);
?>    
