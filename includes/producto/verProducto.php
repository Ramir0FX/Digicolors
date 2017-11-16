<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
$ROL_USUARIO = $_SESSION['MS_USER_ROL_NAME'];

$tabla = "";
/*
 * SQL PRODUCT
 */
$SQL_PRODUCT = "select `id_producto` \"id\", `nombre` \"nombre\", `descripcion` \"descripción\", "
        . "`precio_costo` \"precio costo\", `precio_venta` \"precio venta\", "
        . "(select marca.descripcion from marca where marca.id_marca= producto.id_marca) \"marca\", "
        . "(select impuesto.descripcion from impuesto where impuesto.id_impuesto= producto.id_impuesto) \"impuesto\", "
        . "(select producto_estado.descripcion from producto_estado where producto_estado.id_producto_estado= producto.id_producto_estado) \"estado\", "
        . "(select producto_categoria.descripcion from producto_categoria where producto_categoria.id_producto_categoria= producto.id_producto_categoria) \"categoría\", "
        . "`cant_actual` \"stock\" from `producto`";
$product_list = $conex->query($SQL_PRODUCT)->fetchAll(PDO::FETCH_ASSOC);

$tabla = $tabla . '<table class="table table-hover mb-none">
			            <tr>
					<th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Precio costo</th>
                                            <th>Precio venta</th>
                                            <th>Marca</th>
                                            <th>Impuesto</th>
                                            <th>Estado</th>
                                            <th>Categoría</th>
                                            <th>Stock</th>
                                            <th>Acciones</th>
						</tr>';

foreach ($product_list as $row => $link) {
    $tabla = $tabla . '<tr class="odd gradeX">
                            <td> ' . $link['id'] . ' </td>
                            <td> ' . $link['nombre'] . ' </td>
                            <td> ' . $link['descripción'] . '</td>
                            <td> ' . number_format($link['precio costo'], 0, ".", ".") . ' </td>
                            <td> ' . number_format($link['precio venta'], 0, ".", ".") . ' </td>
                            <td> ' . $link['marca'] . ' </td>
                            <td> ' . $link['impuesto'] . ' </td>
                            <td> ' . $link['estado'] . ' </td>
                            <td> ' . $link['categoría'] . ' </td>
                            <td> ' . $link['stock'] . ' </td>';
    if ($ROL_USUARIO == "Administrador") {
        $tabla = $tabla . '<td class="center">
                <a href="javascript:llamarFormularioEditarProducto(' . $link['id'] . ');" title="Editar producto" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                <a href="javascript:llamarFormularioEliminarProducto(' . $link['id'] . ');" title="Eliminar producto" class="btn btn-danger"> <i class="fa fa-trash-o"></i> </a>
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