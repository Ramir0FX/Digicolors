<?php


$SQL_CUSTOMER = "select id_cliente, concat(cliente.nombre,' ',cliente.apellido)\"cliente\" from cliente order by id_cliente asc";
$job_customer = $conex->query($SQL_CUSTOMER)->fetchAll(PDO::FETCH_ASSOC);

$SQL_EMPLOY = "select id_funcionario, concat(funcionario.nombre,' ',funcionario.apellido)\"funcionario\" from funcionario order by id_funcionario asc";
$job_employ = $conex->query($SQL_EMPLOY)->fetchAll(PDO::FETCH_ASSOC);

$SQL_PRODUCT = "select id_producto, nombre, precio_venta, "
        . "(select marca.descripcion from marca where marca.id_marca= producto.id_marca) \"marca\" "
        . "from `producto` order by nombre asc";
$job_product_list = $conex->query($SQL_PRODUCT)->fetchAll(PDO::FETCH_ASSOC);

$SQL_PEDIDO_ESTADO = "select * from pedido_estado order by id_pedido_estado asc";
$job_order_status = $conex->query($SQL_PEDIDO_ESTADO)->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="modal_modificarPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_modificarPedido" id="form_modificarPedido" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modificar pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control" name="M_PEDIDO_ID_CLIENTE" id="M_PEDIDO_ID_CLIENTE" >
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
                            <select class="form-control" name="M_PEDIDO_ID_FUNCIONARIO" id="M_PEDIDO_ID_FUNCIONARIO" >
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
                                <input name="M_PEDIDO_FECHA_ENTREGA" id="M_PEDIDO_FECHA_ENTREGA" data-plugin-datepicker="" class="form-control" type="text">
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
                                <input name="M_PEDIDO_HORA_ENTREGA" id="M_PEDIDO_HORA_ENTREGA" data-plugin-timepicker="" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" name="M_PEDIDO_ESTADO" id="M_PEDIDO_ESTADO" >
                                <option value="">Seleccione un estado</option>
                                <?PHP
                                foreach ($job_order_status as $value) {
                                    echo ('<option value="' . $value['id_pedido_estado'] . '" >' . $value['descripcion'] . '</option>');
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Producto/servicio </label>
                                <select class="form-control" name="M_PEDIDO_ID_PRODUCTO" id="M_PEDIDO_ID_PRODUCTO" >
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
                                <input class="form-control" name="M_PEDIDO_CANT" id="M_PEDIDO_CANT">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Precio</label>
                                <input class="form-control" name="M_PEDIDO_PRECIO" id="M_PEDIDO_PRECIO">
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea rows="4" class="form-control" name="M_PEDIDO_OBSERVACION" id="M_PEDIDO_OBSERVACION"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <img id="cargandoEdi" hidden src="assets/images/cargando.gif"/>
                    <input type="hidden" name="M_PEDIDO_DIRECCION" id="C_PEDIDO_DIRECCION">
                    <input type="hidden" name="M_PEDIDO_TOTAL" id="M_PEDIDO_TOTAL">
                    <input type="hidden" name="M_PEDIDO_DESCUENTO" id="M_PEDIDO_DESCUENTO">
                    <input type="hidden" value="1" name="modificar_pedido"/>
                    <input type="hidden" value="" name="M_PEDIDO_ID" id="M_PEDIDO_ID"/>
                    <input type="hidden" value="" name="M_PEDIDO_ID_DETALLE" id="M_PEDIDO_ID_DETALLE"/>
                    <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" name="M_PEDIDO_TIEMPO_RECEPCION" id="M_PEDIDO_TIEMPO_RECEPCION"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_modificarPedido">Guardar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_eliminarPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_eliminarPedido" id="form_eliminarPedido" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar pedido</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control" name="E_PEDIDO_ID_CLIENTE" id="E_PEDIDO_ID_CLIENTE" >
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
                            <select class="form-control" name="E_PEDIDO_ID_FUNCIONARIO" id="E_PEDIDO_ID_FUNCIONARIO" >
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
                                <input name="E_PEDIDO_FECHA_ENTREGA" id="E_PEDIDO_FECHA_ENTREGA" data-plugin-datepicker="" class="form-control" type="text">
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
                                <input name="E_PEDIDO_HORA_ENTREGA" id="E_PEDIDO_HORA_ENTREGA" data-plugin-timepicker="" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Condición de venta</label>
                            <select class="form-control" name="E_PEDIDO_ID_COND_VENTA" id="E_PEDIDO_ID_COND_VENTA" >
                                <?PHP
                                foreach ($job_cond_sale as $value) {
                                    echo ('<option value="' . $value['id_tipo_operacion'] . '" >' . $value['descripcion'] . '</option>');
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control" name="E_PEDIDO_ESTADO" id="E_PEDIDO_ESTADO" >
                                <option value="">Estado</option>
                                <?PHP
                                foreach ($job_order_status as $value) {
                                    echo ('<option value="' . $value['id_pedido_estado'] . '" >' . $value['descripcion'] . '</option>');
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input class="form-control" name="E_PEDIDO_DIRECCION" id="E_PEDIDO_DIRECCION">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Observación</label>
                                <input class="form-control" name="E_PEDIDO_OBSERVACION" id="E_PEDIDO_OBSERVACION">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Producto/servicio </label>
                                <select class="form-control" name="E_PEDIDO_ID_PRODUCTO" id="E_PEDIDO_ID_PRODUCTO" >
                                    <?PHP
                                    foreach ($job_product_list as $value) {
                                        echo ('<option value="' . $value['id_producto'] . '" >' . $value['id_producto'] . " - " . $value['nombre'] . " - " . $value['precio_venta'] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input class="form-control" name="E_PEDIDO_CANT" id="E_PEDIDO_CANT">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Precio</label>
                                <input class="form-control" name="E_PEDIDO_PRECIO" id="E_PEDIDO_PRECIO">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Descuento</label>
                                <input class="form-control" name="E_PEDIDO_DESCUENTO" id="E_PEDIDO_DESCUENTO">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Total</label>
                                <input class="form-control" name="E_PEDIDO_TOTAL" id="E_PEDIDO_TOTAL">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="eliminar_pedido"/>
                    <input type="hidden" value="" name="E_PEDIDO_ID" id="E_PEDIDO_ID"/>
                    <input type="hidden" value="" name="E_PEDIDO_ID_DETALLE" id="E_PEDIDO_ID_DETALLE"/>
                    <input type="text" readonly value="<?php echo date('Y-m-d H:i:s'); ?>" name="E_PEDIDO_TIEMPO_RECEPCION" id="E_PEDIDO_TIEMPO_RECEPCION"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_eliminarPedido">Eliminar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>