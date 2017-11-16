<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
$ROL_USUARIO = $_SESSION['MS_USER_ROL_NAME'];

$tabla = "";
/*
 * SQL PRODUCT
 */

$SQL_PRODUCTO_CATEGORIA = "select * from producto_categoria order by id_producto_categoria asc";
$product_category_list = $conex->query($SQL_PRODUCTO_CATEGORIA)->fetchAll(PDO::FETCH_ASSOC);

$tabla = $tabla . '<table class="table table-hover mb-none">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>';

foreach ($product_category_list as $row => $link) {
    $tabla = $tabla . '<tr class="odd gradeX">
                            <td> ' . $link['id_producto_categoria'] . ' </td>
                            <td> ' . $link['descripcion'] . ' </td>';
    if ($ROL_USUARIO == "Administrador") {
        $tabla = $tabla . '<td class="center">
                <a href="javascript:llamarFormularioEditarCategoria(' . $link['id_producto_categoria'] . ');" title="Editar categoría" class="btn btn-warning"> <i class="fa fa-pencil"></i> </a>
                <a href="javascript:llamarFormularioEliminarCategoria(' . $link['id_producto_categoria'] . ');" title="Eliminar categoría" class="btn btn-danger"> <i class="fa fa-trash-o"></i> </a>
            </td>
        </tr>';
    } elseif ($ROL_USUARIO == "Funcionario") {
        $tabla = $tabla . '<td> Sin acciones </td>
        </tr>';
    }
}
$tabla = $tabla . '</table>';
$array = array(
    0 => $tabla);

echo json_encode($array);
?>