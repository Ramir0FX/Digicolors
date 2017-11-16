<div class="modal fade" id="modal_eliminarCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form_eliminarCategoria" id="form_eliminarCategoria" >
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Eliminar categoría</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>¿Esta seguro que desea eliminar esta categoría?</label>
                                <input readonly class="form-control" name="E_CATEGORIA_NOMBRE" id="E_CATEGORIA_NOMBRE">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="1" name="eliminar_categoria"/>
                    <input type="hidden" value="" name="E_CATEGORIA_ID" id="E_CATEGORIA_ID"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_eliminarCategoria">Confirmar</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
