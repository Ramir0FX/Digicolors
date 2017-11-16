<?php

$SQL_MARK = "select * from marca order by id_marca asc";
$product_mark = $conex->query($SQL_MARK)->fetchAll(PDO::FETCH_ASSOC);

$SQL_TAX = "select * from impuesto order by id_impuesto asc";
$product_tax = $conex->query($SQL_TAX)->fetchAll(PDO::FETCH_ASSOC);

$SQL_PROD_STATUS = "select * from producto_estado order by id_producto_estado asc";
$product_status = $conex->query($SQL_PROD_STATUS)->fetchAll(PDO::FETCH_ASSOC);

$SQL_PROD_CATEGORY = "select * from producto_categoria order by id_producto_categoria asc";
$product_category = $conex->query($SQL_PROD_CATEGORY)->fetchAll(PDO::FETCH_ASSOC);

$SQL_PROD_STATE = "select * from producto_estado order by id_producto_estado asc";
$product_state = $conex->query($SQL_PROD_STATE)->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="modal fade" id="modificarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_update_product" id="form_update_product" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modificar producto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Nombre de producto</label>
                                <input class="form-control" name="M_NOMBRE" id="M_NOMBRE">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Descripci??n de producto</label>
                                <input class="form-control" name="M_DESCRIPCION" id="M_DESCRIPCION">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input class="form-control" name="M_CANT_ACTUAL" id="M_CANT_ACTUAL">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="M_ID_ESTADO" id="M_ID_ESTADO" >
                                    <option value="">Seleccione un estado</option>
                                    <?PHP
                                    foreach ($product_state as $value) {
                                        echo ('<option value="' . $value['id_producto_estado'] . '" >' . $value['descripcion'] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Impuesto</label>
                                <select class="form-control" name="M_ID_IMPUESTO" id="M_ID_IMPUESTO" >
                                    <option value="">Seleccione un impuesto</option>
                                    <?PHP
                                    foreach ($product_tax as $value) {
                                        echo ('<option value="' . $value['id_impuesto'] . '" >' . $value['descripcion'] . '%' . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Precio de costo</label>
                                <input class="form-control" name="M_PRECIO_COSTO" id="M_PRECIO_COSTO">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Precio de venta</label>
                                <input class="form-control" name="M_PRECIO_VENTA" id="M_PRECIO_VENTA">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Categor??as</label>
                                <select class="form-control" name="M_ID_CATEGORIA" id="M_ID_CATEGORIA" >
                                    <option value="">Seleccione una categoria</option>
                                    <?PHP
                                    foreach ($product_category as $value) {
                                        echo ('<option value="' . $value['id_producto_categoria'] . '" >' . $value['descripcion'] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Marcas</label>
                                <select class="form-control" id="M_ID_MARCA" name="M_ID_MARCA">
                                    <option value="">Seleccione una marca</option>
                                    <?PHP
                                    foreach ($product_mark as $value) {
                                        echo ('<option value="' . $value['id_marca'] . '" >' . $value['descripcion'] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="modificar_producto"/>
                    <input type="hidden" value="" name="M_ID" id="M_ID"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_modificarProducto">Modificar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
