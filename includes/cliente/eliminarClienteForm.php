<div class="modal fade" id="modal_eliminarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_eliminarCliente" id="form_eliminarCliente" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>¿Esta seguro que desea eliminar este cliente?</label>
                                <input readonly class="form-control" name="E_CLIENTE_NOMBRE" id="E_CLIENTE_NOMBRE">
                                <input readonly class="form-control" name="E_CLIENTE_RUC_CI" id="E_CLIENTE_RUC_CI">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="eliminar_cliente"/>
                    <input type="hidden" value="" name="E_CLIENTE_ID" id="E_CLIENTE_ID"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_eliminarCliente">Confirmar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
