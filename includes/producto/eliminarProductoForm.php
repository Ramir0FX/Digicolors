<div class="modal fade" id="modal_eliminarProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_eliminarProducto" id="form_eliminarProducto" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar producto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>¿Esta seguro que desea eliminar este producto?</label>
                                <input readonly class="form-control" name="E_PRODUCTO_NOMBRE" id="E_PRODUCTO_NOMBRE">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="eliminar_producto"/>
                    <input type="hidden" value="" name="E_PRODUCTO_ID" id="E_PRODUCTO_ID"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_eliminarProducto">Confirmar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
