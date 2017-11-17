<?php
$SQL_PEDIDO_ESTADO = "select * from pedido_estado order by id_pedido_estado asc";
$job_order_status = $conex->query($SQL_PEDIDO_ESTADO)->fetchAll(PDO::FETCH_ASSOC);

$sql_customer = "select id_cliente, concat(cliente.nombre,' ',cliente.apellido)\"cliente\", ruc_ci from cliente order by id_cliente asc";
$job_customer = $conex->query($sql_customer)->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
    <form name="form_filtrarReporte" id="form_filtrarReporte" >
        <div class="modal-body">
            <!-- RANGO DE FECHAS-->
            <div class="form-group row">
                <label class="col-lg-3 control-label text-lg-right pt-2">Rango de fecha</label>
                <div class="col-lg-6">
                    <div class="input-daterange input-group" data-plugin-datepicker="">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control" name="R_REPORTE_FECHA_INICIO" id="R_REPORTE_FECHA_INICIO" >
                        <span class="input-group-addon">hasta</span>
                        <input type="text" class="form-control" name="R_REPORTE_FECHA_FIN" id="R_REPORTE_FECHA_FIN" >
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group">
                    <label  class="col-lg-3 control-label text-lg-right pt-2">Cliente</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="R_REPORTE_ID_CLIENTE" id="R_REPORTE_ID_CLIENTE" >
                            <option value="0">Todos los clientes</option>
                            <?PHP
                            foreach ($job_customer as $value) {
                                echo ('<option value="' . $value['id_cliente'] . '" >' . $value['cliente'] . ' - ' . $value['ruc_ci'] . '</option>');
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group">
                    <label  class="col-lg-3 control-label text-lg-right pt-2">Estado</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="R_REPORTE_ESTADO" id="R_REPORTE_ESTADO" >
                            <option value="0">Todos los estados</option>
                            <?PHP
                            foreach ($job_order_status as $value) {
                                echo ('<option value="' . $value['id_pedido_estado'] . '" >' . $value['descripcion'] . '</option>');
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" value="1" name="filtrar_reporte"/>
            <a href="index.php" class="btn btn-warning">Volver atrás</a>
            <button type="submit" class="btn btn-info" id="btn_filtrarReporte">Ver reporte</button>
        </div>
    </form>
</div>