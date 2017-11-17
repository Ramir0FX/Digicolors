<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');
if ((isset($_POST['filtrar_reporte'])) && ($_POST['filtrar_reporte'] == 1)) {
    global $conex;
    $PEDIDO_ESTADO = $_POST['R_REPORTE_ESTADO'];
    $PEDIDO_ID_CLIENTE = $_POST['R_REPORTE_ID_CLIENTE'];

    $date_recepcion = date_create($_POST['R_REPORTE_FECHA_INICIO'] . " 00:00:00");
    $date_entrega = date_create($_POST['R_REPORTE_FECHA_FIN'] . " 23:59:59");
    $PEDIDO_TIEMPO_ENTREGA = date_format($date_entrega, 'Y/m/d H:i:s');
    $PEDIDO_TIEMPO_RECEPCION = date_format($date_recepcion, 'Y/m/d H:i:s');

    $sql = "select peca.id_pedido_cabecera \"id\", `tiempo_recepcion`, `tiempo_entrega`, "
            . "(select pedido_estado.descripcion from pedido_estado where pedido_estado.id_pedido_estado = peca.id_pedido_estado)\"estado\", "
            . "(select prod.nombre from producto prod where prod.id_producto = pede.id_producto) \"producto\", "
            . "(select sum(pede.cantidad*(pede.precio-(pede.precio*pede.descuento)/100)) from pedido_detalle pede where pede.id_pedido_cabecera = peca.id_pedido_cabecera)  \"total\" "
            . "from pedido_cabecera peca, pedido_detalle pede "
            . "where peca.id_pedido_cabecera = pede.id_pedido_cabecera "
            . "and peca.tiempo_recepcion between :pedido_tiempo_recepcion and :pedido_tiempo_entrega ";
    if ($PEDIDO_ESTADO == 0) {
        $sql = $sql . "and peca.id_pedido_estado in (1,2,3,4) ";
    } else {
        $sql = $sql . "and peca.id_pedido_estado = :pedido_estado ";
    }
    if ($PEDIDO_ID_CLIENTE != 0) {
        $sql = $sql . "and peca.id_cliente = :pedido_id_cliente";
    }

    $stmt = $conex->prepare($sql);
    if ($PEDIDO_ESTADO == 0 && $PEDIDO_ID_CLIENTE == 0) {
        $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA]);
    } elseif ($PEDIDO_ESTADO != 0 && $PEDIDO_ID_CLIENTE == 0) {
        $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA, $PEDIDO_ESTADO]);
    } elseif ($PEDIDO_ESTADO == 0 && $PEDIDO_ID_CLIENTE != 0) {
        $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA, $PEDIDO_ID_CLIENTE]);
    } elseif ($PEDIDO_ESTADO != 0 && $PEDIDO_ID_CLIENTE != 0) {
        $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA, $PEDIDO_ESTADO, $PEDIDO_ID_CLIENTE]);
    }

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $tabla = "";
    $sumatotal = 0;
    $tabla = $tabla . '<table class="table table-hover mb-none">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto/Servicio</th>
                                <th>Tiempo recepción</th>
                                <th>Tiempo entrega</th>
                                <th>Sub-Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead> 
                        <tbody>';
    foreach ($data as $row => $link) {
        $tabla = $tabla . '
                                <tr class="odd gradeX">
                                <td>' . $link['id'] . '</td>
                                <td>' . $link['producto'] . '</td>
                                <td>' . strftime('%d/%b/%y %H:%M', strtotime($link['tiempo_recepcion'])) . '</td>
                                <td>' . strftime('%d/%b/%y %H:%M', strtotime($link['tiempo_entrega'])) . '</td>
                                <td>' . number_format($link['total'], 0, ".", ".") . '</td>'
?><?php

        if ($link['estado'] == 'Pendiente') {
            $tabla = $tabla . '<td> <span class="badge badge-info verde">' . $link['estado'] . '</span></td>';
        } elseif ($link['estado'] == 'Entregado') {
            $tabla = $tabla . '<td> <span class="badge badge-info">' . $link['estado'] . '</span></td>';
        } elseif ($link['estado'] == 'Cancelado') {
            $tabla = $tabla . '<td> <span class="badge badge-info naranja">' . $link['estado'] . '</span></td>';
        } elseif ($link['estado'] == 'Aplazado') {
            $tabla = $tabla . '<td> <span class="badge badge-info rojo">' . $link['estado'] . '</span></td>';
        }
?><?php

        '</tr>
                     ';
        $sumatotal = $sumatotal + $link['total'];
    }
    $tabla = $tabla . '<tfoot>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td align="right"><strong>Total</strong></td>
      <td><strong>' . number_format($sumatotal, 0, ".", ".") . ' Gs.</strong></td>
    </tr>
  </tfoot></tbody></table>
            <a target="_blank" href="includes/reporte/imprimirReporte.php?d=' . $PEDIDO_TIEMPO_RECEPCION . '&h=' . $PEDIDO_TIEMPO_ENTREGA . '&estado='.$PEDIDO_ESTADO.'&cliente='.$PEDIDO_ID_CLIENTE.' " class="btn btn-success pull-right">Imprimir informe</a>';
    $array = array(0 => $tabla);
    echo json_encode($array);
}
?>
