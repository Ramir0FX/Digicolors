<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

$tabla = "";
/*
 * SQL EMPLOY
 */
$sql_employs = "select `id_funcionario` \"id\", concat(nombre,' ',apellido)\"nombre\", `cedula` \"cedula\", "
        . "(select descripcion from funcionario_estado where funcionario_estado.id_funcionario_estado = funcionario.id_funcionario_estado)\"estado\", "
        . "`fecha_ingreso` \"fecha ingreso\", `fecha_salida` \"fecha salida\", `salario` \"salario\", "
        . "`telefono` \"telefono\", `email` \"email\", `direccion` \"dirección\" from `funcionario`";
$employ_list = $conex->query($sql_employs)->fetchAll(PDO::FETCH_ASSOC);
$total_row_employ = count($sql_employs);

$tabla = $tabla . '<table class="table table-hover mb-none">
			            <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>cedula</th>
                                            <th>Estado</th>
                                            <th>Fecha ingreso</th>
                                            <th>Fecha salida</th>
                                            <th>Salario</th>
                                            <th>Telefono</th>
                                            <th>Email</th>
                                            <th>Direccion</th>
                                        </tr>';
foreach ($employ_list as $row => $link) {
    $tabla = $tabla . '<tr class="odd gradeX">
                            <td> ' . $link['id'] . ' </td>
                            <td> ' . $link['nombre'] . ' </td>
                            <td> ' . $link['cedula'] . '</td>
                            <td> ' . $link['estado'] . ' </td>
                            <td> ' . $link['fecha ingreso'] . ' </td>
                            <td> ' . $link['fecha salida'] . ' </td>
                            <td> ' . $link['salario'] . ' </td>
                            <td> ' . $link['telefono'] . ' </td>
                            <td> ' . $link['email'] . ' </td>
                            <td> ' . $link['dirección'] . ' </td>
                        </tr>';
}
$tabla = $tabla . '</table>';
$array = array(
    0 => $tabla);

echo json_encode($array);
?>    
