<?php
$SQL_CUSTOMER = "select id_cliente, concat(cliente.nombre,' ',cliente.apellido)\"cliente\" from cliente order by id_cliente asc";
$job_customer = $conex->query($SQL_CUSTOMER)->fetchAll(PDO::FETCH_ASSOC);

$SQL_EMPLOY = "select id_funcionario, concat(funcionario.nombre,' ',funcionario.apellido)\"funcionario\" from funcionario order by id_funcionario asc";
$job_employ = $conex->query($SQL_EMPLOY)->fetchAll(PDO::FETCH_ASSOC);

$SQL_PRODUCT = "select id_producto, nombre, precio_venta, "
        . "(select marca.descripcion from marca where marca.id_marca= producto.id_marca) \"marca\" "
        . "from `producto` order by nombre asc";
$job_product_list = $conex->query($SQL_PRODUCT)->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="modal_agregarPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_agregarPedido" id="form_agregarPedido" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Agregar pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control" name="C_PEDIDO_ID_CLIENTE" id="C_PEDIDO_ID_CLIENTE" >
                                <option value="">Seleccione un cliente</option>
                                <?PHP
                                foreach ($job_customer as $value) {
                                    echo ('<option value="' . $value['id_cliente'] . '" >' . $value['cliente'] . '</option>');
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Funcionario</label>
                            <select class="form-control" name="C_PEDIDO_ID_FUNCIONARIO" id="C_PEDIDO_ID_FUNCIONARIO" >
                                <option value="">Seleccione un funcionario</option>
                                <?PHP
                                foreach ($job_employ as $value) {
                                    echo ('<option value="' . $value['id_funcionario'] . '" >' . $value['funcionario'] . '</option>');
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Fecha entrega</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input name="C_PEDIDO_FECHA_ENTREGA" id="C_PEDIDO_FECHA_ENTREGA" data-plugin-datepicker="" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Hora entrega</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <input type="text" data-plugin-timepicker="" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false}" name="C_PEDIDO_HORA_ENTREGA" id="C_PEDIDO_HORA_ENTREGA">
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Producto/servicio </label>
                                <select class="form-control" name="C_PEDIDO_ID_PRODUCTO" id="C_PEDIDO_ID_PRODUCTO" >
                                    <option value="">Seleccione un servicio</option>
                                    <?PHP
                                    foreach ($job_product_list as $value) {
                                        echo ('<option value="' . $value['id_producto'] . '" >' . $value['nombre'] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input class="form-control" name="C_PEDIDO_CANT" id="C_PEDIDO_CANT">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Precio</label>
                                <input class="form-control" name="C_PEDIDO_PRECIO" id="C_PEDIDO_PRECIO">
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea class="form-control" rows="4" name="C_PEDIDO_OBSERVACION_CABECERA" id="C_PEDIDO_OBSERVACION_CABECERA"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <img id="cargandoAdd" hidden src="assets/images/cargando.gif"/>
                    <input type="hidden" value="0" name="C_PEDIDO_DIRECCION" id="C_PEDIDO_DIRECCION">
                    <input type="hidden" value="0" name="C_PEDIDO_DESCUENTO" id="C_PEDIDO_DESCUENTO">
                    <input type="hidden" value="0" name="C_PEDIDO_TOTAL" id="C_PEDIDO_TOTAL">
                    <input type="hidden" value="1" name="agregar_pedido"/>
                    <input type="hidden" value="" name="C_PEDIDO_ID" id="C_PEDIDO_ID"/>
                    <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" name="C_PEDIDO_TIEMPO_ACTUAL" id="C_PEDIDO_TIEMPO_ACTUAL"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_agregarPedido">Guardar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
