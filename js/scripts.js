$(function () {
    /*
     * PRODUCTO
     */
    $('#btn_agregarProducto').on('click', function () {
        $('#form_add_product').validate({
            rules: {
                C_NOMBRE: {
                    required: true,
                    rangelength: [2, 50]
                },
                C_DESCRIPCION: {
                    rangelength: [2, 255]
                },
                C_CANT_ACTUAL: {
                    number: true
                },
                C_PRECIO_COSTO: {
                    required: true,
                    number: true
                },
                C_PRECIO_VENTA: {
                    required: true,
                    number: true
                },
                C_ID_CATEGORIA: {
                    required: true,
                    number: true
                },
                C_ID_MARCA: {
                    required: true,
                    number: true
                },
                C_ID_IMPUESTO: {
                    required: true,
                    number: true
                }
            },
            messages: {
                C_NOMBRE: {
                    required: "Ingrese el nombre del producto",
                    rangelength: "Por favor, ingrese un valor entre 2 y 50 caracteres"
                },
                C_DESCRIPCION: {
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                },
                C_CANT_ACTUAL: {
                    number: "Por favor, ingrese solo números"
                },
                C_PRECIO_COSTO: {
                    required: "Ingrese el precio de costo",
                    number: "Por favor, ingrese solo números"
                },
                C_PRECIO_VENTA: {
                    required: "Ingrese el precio de venta",
                    number: "Por favor, ingrese solo números"
                },
                C_ID_CATEGORIA: {
                    required: "Seleccione una categoría",
                    number: "Por favor, ingrese solo números"
                },
                C_ID_MARCA: {
                    required: "Seleccione una marca",
                    number: "Por favor, ingrese solo números"
                },
                C_ID_IMPUESTO: {
                    required: "Seleccione un impuesto",
                    number: "Por favor, ingrese solo números"
                }
            },
            submitHandler: function (form) {
                $('#cargandoAdd').show();
                var dataString = $('#form_add_product').serialize();
                var url = 'includes/producto/crearProducto.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $('#cargandoAdd').hide();
                        $("#agregarProducto").modal("hide");
                        $("#info").html(form);
                        verProducto();
                        $('#form_add_product')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_modificarProducto').on('click', function () {
        $('#form_update_product').validate({
            rules: {
                M_NOMBRE: {
                    required: true,
                    rangelength: [2, 50]
                },
                M_DESCRIPCION: {
                    rangelength: [2, 255]
                },
                M_CANT_ACTUAL: {
                    number: true
                },
                M_PRECIO_COSTO: {
                    required: true,
                    number: true
                },
                M_PRECIO_VENTA: {
                    required: true,
                    number: true
                },
                M_ID_CATEGORIA: {
                    required: true,
                    number: true
                },
                M_ID_MARCA: {
                    required: true,
                    number: true
                },
                M_ID_ESTADO: {
                    required: true,
                    number: true
                },
                M_ID_IMPUESTO: {
                    required: true,
                    number: true
                }
            },
            messages: {
                M_NOMBRE: {
                    required: "Ingrese el nombre del producto",
                    rangelength: "Por favor, ingrese un valor entre 2 y 50 caracteres"
                },
                M_DESCRIPCION: {
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                },
                M_CANT_ACTUAL: {
                    number: "Por favor, ingrese solo números"
                },
                M_PRECIO_COSTO: {
                    required: "Ingrese el precio de costo",
                    number: "Por favor, ingrese solo números"
                },
                M_PRECIO_VENTA: {
                    required: "Ingrese el precio de venta",
                    number: "Por favor, ingrese solo números"
                },
                M_CANT_ACTUAL: {
                    required: "Ingrese el stock inicial",
                    number: "Por favor, ingrese solo números"
                },
                M_ID_CATEGORIA: {
                    required: "Seleccione una categoría",
                    number: "Por favor, ingrese solo números"
                },
                M_ID_MARCA: {
                    required: "Seleccione una marca",
                    number: "Por favor, ingrese solo números"
                },
                M_ID_ESTADO: {
                    required: "Seleccione un estado",
                    number: "Por favor, ingrese solo números"
                },
                M_ID_IMPUESTO: {
                    required: "Seleccione un impuesto",
                    number: "Por favor, ingrese solo números"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_update_product').serialize();
                var url = 'includes/producto/modificarProducto.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modificarProducto").modal("hide");
                        $("#info").html(form);
                        verProducto();
                        $('#form_update_product')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_eliminarProducto').on('click', function () {
        $('#form_eliminarProducto').validate({
            rules: {
                E_PRODUCTO_NOMBRE: {
                    required: true,
                    rangelength: [2, 255]
                }
            },
            messages: {
                E_PRODUCTO_NOMBRE: {
                    required: "Por favor, ingrese un nombre para el producto.",
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_eliminarProducto').serialize();
                var url = 'includes/producto/eliminarProducto.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_eliminarProducto").modal("hide");
                        $("#info").html(form);
                        verProducto();
                        $('#form_eliminarProducto')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    /*
     * PEDIDO
     */
    $('#btn_entregarPedido').on('click', function () {
        $('#form_entregarPedido').validate({
            rules: {
                P_PEDIDO_ID: {
                    required: true,
                    number: true
                }
            },
            messages: {
                P_PEDIDO_ID: {
                    required: "Por favor, ingrese un ID para el pedido.",
                    number: "Por favor, ingrese un valor numérico."
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_entregarPedido').serialize();
                var url = 'includes/pedido/entregarPedido.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_entregarPedido").modal("hide");
                        $("#info").html(form);
                        controlarEstadoPedidos();
                        $('#form_entregarPedido')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_agregarPedido').on('click', function () {
        $('#form_agregarPedido').validate({
            rules: {
                C_PEDIDO_ID_CLIENTE: {
                    required: true,
                    number: true
                },
                C_PEDIDO_ID_FUNCIONARIO: {
                    required: true,
                    number: true
                },
                C_PEDIDO_FECHA_ENTREGA: {
                    required: true
                },
                C_PEDIDO_HORA_ENTREGA: {
                    required: true
                },
                C_PEDIDO_ID_COND_VENTA: {
                    required: true,
                    number: true
                },
                C_PEDIDO_ID_PRODUCTO: {
                    required: true,
                    number: true
                },
                C_PEDIDO_CANT: {
                    required: true,
                    number: true
                },
                C_PEDIDO_PRECIO: {
                    required: true,
                    number: true
                },
                C_PEDIDO_DESCUENTO: {
                    number: true
                }
            },
            messages: {
                C_PEDIDO_ID_CLIENTE: {
                    required: "Seleccione un cliente",
                    number: "Por favor, ingrese solo números"
                },
                C_PEDIDO_ID_FUNCIONARIO: {
                    required: "Seleccione un funcionario",
                    number: "Por favor, ingrese solo números"
                },
                C_PEDIDO_FECHA_ENTREGA: {
                    required: "Seleccione una fecha de entrega"
                },
                C_PEDIDO_HORA_ENTREGA: {
                    required: "Seleccione una hora de entrega",
                },
                C_PEDIDO_ID_COND_VENTA: {
                    required: "Seleccione una condición de venta",
                    number: "Por favor, ingrese solo números"
                },
                C_PEDIDO_ID_PRODUCTO: {
                    required: "Seleccione un producto/servicio",
                    number: "Por favor, ingrese solo números"
                },
                C_PEDIDO_CANT: {
                    required: "Ingrese una cantidad",
                    number: "Por favor, ingrese solo números"
                },
                C_PEDIDO_PRECIO: {
                    required: "Ingrese un precio",
                    number: "Por favor, ingrese solo números"
                },
                C_PEDIDO_DESCUENTO: {
                    number: "Por favor, ingrese solo números"
                }
            },
            submitHandler: function (form) {
                $('#cargandoAdd').show();
                var dataString = $('#form_agregarPedido').serialize();
                var url = 'includes/pedido/crearPedido.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_agregarPedido").modal("hide");
                        $('#cargandoAdd').hide();
                        $("#info").html(form);
                        verPedido();
                        $('#form_agregarPedido')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_modificarPedido').on('click', function () {
        $('#form_modificarPedido').validate({
            rules: {
                M_PEDIDO_ID_CLIENTE: {
                    required: true,
                    number: true
                },
                M_PEDIDO_ID_FUNCIONARIO: {
                    required: true,
                    number: true
                },
                M_PEDIDO_FECHA_ENTREGA: {
                    required: true
                },
                M_PEDIDO_HORA_ENTREGA: {
                    required: true
                },
                M_PEDIDO_ID_COND_VENTA: {
                    required: true,
                    number: true
                },
                M_PEDIDO_ESTADO: {
                    required: true,
                    number: true
                },
                M_PEDIDO_ID_PRODUCTO: {
                    required: true,
                    number: true
                },
                M_PEDIDO_CANT: {
                    required: true,
                    number: true
                },
                M_PEDIDO_PRECIO: {
                    required: true,
                    number: true
                },
                M_PEDIDO_DESCUENTO: {
                    number: true
                }
            },
            messages: {
                M_PEDIDO_ID_CLIENTE: {
                    required: "Seleccione un cliente",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_ID_FUNCIONARIO: {
                    required: "Seleccione un funcionario",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_FECHA_ENTREGA: {
                    required: "Seleccione una fecha de entrega",
                    date: "Por favor, ingrese solo fechas"
                },
                M_PEDIDO_HORA_ENTREGA: {
                    required: "Seleccione una hora de entrega"
                },
                M_PEDIDO_ID_COND_VENTA: {
                    required: "Seleccione una condición de venta",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_ESTADO: {
                    required: "Seleccione un estado",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_ID_PRODUCTO: {
                    required: "Seleccione un producto/servicio",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_CANT: {
                    required: "Ingrese una cantidad",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_PRECIO: {
                    required: "Ingrese un precio",
                    number: "Por favor, ingrese solo números"
                },
                M_PEDIDO_DESCUENTO: {
                    number: "Por favor, ingrese solo números"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_modificarPedido').serialize();
                var url = 'includes/pedido/modificarPedido.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_modificarPedido").modal("hide");
                        $("#info").html(form);
                        verPedido();
                        $('#form_modificarPedido')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    /*
     * CLIENTE
     */
    $('#btn_agregarCliente').on('click', function () {
        $('#form_agregarCliente').validate({
            rules: {
                C_CLIENTE_NOMBRE: {
                    required: true,
                    rangelength: [2, 50]
                },
                C_CLIENTE_APELLIDO: {
                    rangelength: [0, 50]
                },
                C_CLIENTE_RUC_CI: {
                    required: true,
                    rangelength: [1, 50]
                },
                C_CLIENTE_RUC_ID: {
                    rangelength: [0, 10]
                },
                C_CLIENTE_TELEFONO: {
                    rangelength: [0, 50]
                },
                C_CLIENTE_ID_CATEGORIA: {
                    required: true,
                    number: true
                },
                C_CLIENTE_ID_TIPO: {
                    required: true,
                    number: true
                },
                C_CLIENTE_EMAIL: {
                    rangelength: [0, 50]
                },
                C_CLIENTE_PAGWEB: {
                    rangelength: [0, 50]
                },
                C_CLIENTE_DIRECCION: {
                    rangelength: [0, 255]
                },
                C_CLIENTE_OBSERVACION: {
                    rangelength: [0, 255]
                }
            },
            messages: {
                C_CLIENTE_NOMBRE: {
                    required: "Por favor, ingrese un nombre de cliente.",
                    rangelength: "Por favor, ingrese un valor entre 2 y 50 caracteres"
                },
                C_CLIENTE_APELLIDO: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                C_CLIENTE_RUC_CI: {
                    required: "Por favor, ingrese un RUC o CI de cliente.",
                    rangelength: "Por favor, ingrese un valor entre 1 y 50 caracteres"
                },
                C_CLIENTE_RUC_ID: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 10 caracteres"
                },
                C_CLIENTE_TELEFONO: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                C_CLIENTE_ID_CATEGORIA: {
                    required: "Por favor, seleccione una categoría de cliente.",
                    number: "Por favor, seleccione una categoría valida."
                },
                C_CLIENTE_ID_TIPO: {
                    required: "Por favor, seleccione un tipo de cliente.",
                    number: "Por favor, seleccione un tipo valido."
                },
                C_CLIENTE_EMAIL: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                C_CLIENTE_PAGWEB: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                C_CLIENTE_DIRECCION: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 255 caracteres"
                },
                C_CLIENTE_OBSERVACION: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 255 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_agregarCliente').serialize();
                var url = 'includes/cliente/crearCliente.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_agregarCliente").modal("hide");
                        $("#info").html(form);
                        verCliente();
                        $('#form_agregarCliente')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_modificarCliente').on('click', function () {
        $('#form_modificarCliente').validate({
            rules: {
                M_CLIENTE_NOMBRE: {
                    required: true,
                    rangelength: [2, 50]
                },
                M_CLIENTE_APELLIDO: {
                    rangelength: [0, 50]
                },
                M_CLIENTE_RUC_CI: {
                    required: true,
                    rangelength: [1, 50]
                },
                M_CLIENTE_RUC_ID: {
                    rangelength: [0, 10]
                },
                M_CLIENTE_TELEFONO: {
                    rangelength: [0, 50]
                },
                M_CLIENTE_ID_CATEGORIA: {
                    required: true,
                    number: true
                },
                M_CLIENTE_ID_TIPO: {
                    required: true,
                    number: true
                },
                M_CLIENTE_EMAIL: {
                    rangelength: [0, 50]
                },
                M_CLIENTE_PAGWEB: {
                    rangelength: [0, 50]
                },
                M_CLIENTE_DIRECCION: {
                    rangelength: [0, 255]
                },
                M_CLIENTE_OBSERVACION: {
                    rangelength: [0, 255]
                }
            },
            messages: {
                M_CLIENTE_NOMBRE: {
                    required: "Por favor, ingrese un nombre de cliente.",
                    rangelength: "Por favor, ingrese un valor entre 2 y 50 caracteres"
                },
                M_CLIENTE_APELLIDO: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                M_CLIENTE_RUC_CI: {
                    required: "Por favor, ingrese un RUC o CI de cliente.",
                    rangelength: "Por favor, ingrese un valor entre 1 y 50 caracteres"
                },
                M_CLIENTE_RUC_ID: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 10 caracteres"
                },
                M_CLIENTE_TELEFONO: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                M_CLIENTE_ID_CATEGORIA: {
                    required: "Por favor, seleccione una categoría de cliente.",
                    number: "Por favor, seleccione una categoría valida."
                },
                M_CLIENTE_ID_TIPO: {
                    required: "Por favor, seleccione un tipo de cliente.",
                    number: "Por favor, seleccione un tipo valido."
                },
                M_CLIENTE_EMAIL: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                M_CLIENTE_PAGWEB: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 50 caracteres"
                },
                M_CLIENTE_DIRECCION: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 255 caracteres"
                },
                M_CLIENTE_OBSERVACION: {
                    rangelength: "Por favor, ingrese un valor entre 0 y 255 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_modificarCliente').serialize();
                var url = 'includes/cliente/modificarCliente.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_modificarCliente").modal("hide");
                        $("#info").html(form);
                        verCliente();
                        $('#form_modificarCliente')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_eliminarCliente').on('click', function () {
        $('#form_eliminarCliente').validate({
            rules: {
                E_CLIENTE_NOMBRE: {
                    required: true,
                    rangelength: [2, 255]
                },
                E_CLIENTE_RUC_CI: {
                    required: true,
                    rangelength: [1, 50]
                }
            },
            messages: {
                E_CLIENTE_NOMBRE: {
                    required: "Por favor, ingrese un nombre para el cliente.",
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                },
                E_CLIENTE_RUC_CI: {
                    required: "Por favor, ingrese un RUC/CI para el cliente.",
                    rangelength: "Por favor, ingrese un valor entre 1 y 30 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_eliminarCliente').serialize();
                var url = 'includes/cliente/eliminarCliente.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_eliminarCliente").modal("hide");
                        $("#info").html(form);
                        verCliente();
                        $('#form_eliminarCliente')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    /*
     * MARCA
     */
    $('#btn_agregarMarca').on('click', function () {
        $('#form_agregarMarca').validate({
            rules: {
                C_MARCA_NOMBRE: {
                    required: true,
                    rangelength: [2, 50]
                }
            },
            messages: {
                C_MARCA_NOMBRE: {
                    required: "Por favor, ingrese un nombre de Marca.",
                    rangelength: "Ingrese entre 2 y 50 caracters, por favor."
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_agregarMarca').serialize();
                var url = 'includes/producto/marca/crearMarca.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_agregarMarca").modal("hide");
                        $("#info").html(form);
                        verMarca();
                        $('#form_agregarMarca')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_modificarMarca').on('click', function () {
        $('#form_modificarMarca').validate({
            rules: {
                M_MARCA_NOMBRE: {
                    required: true,
                    rangelength: [2, 255]
                }
            },
            messages: {
                M_MARCA_NOMBRE: {
                    required: "Por favor, ingrese un nombre para la Marca",
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_modificarMarca').serialize();
                var url = 'includes/producto/marca/modificarMarca.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_modificarMarca").modal("hide");
                        $("#info").html(form);
                        verMarca()();
                        $('#form_modificarMarca')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_eliminarMarca').on('click', function () {
        $('#form_eliminarMarca').validate({
            rules: {
                E_MARCA_NOMBRE: {
                    required: true,
                    rangelength: [2, 255]
                }
            },
            messages: {
                E_MARCA_NOMBRE: {
                    required: "Por favor, ingrese un nombre para la Marca",
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_eliminarMarca').serialize();
                var url = 'includes/producto/marca/eliminarMarca.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_eliminarMarca").modal("hide");
                        $("#info").html(form);
                        verMarca();
                        $('#form_eliminarMarca')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    /*
     * CATEGORIA
     */
    $('#btn_agregarCategoria').on('click', function () {
        $('#form_agregarCategoria').validate({
            rules: {
                C_CATEGORIA_NOMBRE: {
                    required: true,
                    rangelength: [2, 50]
                }
            },
            messages: {
                C_CATEGORIA_NOMBRE: {
                    required: "Por favor, ingrese un nombre de categoría.",
                    rangelength: "Ingrese entre 2 y 50 caracters, por favor."
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_agregarCategoria').serialize();
                var url = 'includes/producto/categoria/crearCategoria.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_agregarCategoria").modal("hide");
                        $("#info").html(form);
                        verCategoria();
                        $('#form_agregarCategoria')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_modificarCategoria').on('click', function () {
        $('#form_modificarCategoria').validate({
            rules: {
                M_CATEGORIA_NOMBRE: {
                    required: true,
                    rangelength: [2, 255]
                }
            },
            messages: {
                M_CATEGORIA_NOMBRE: {
                    required: "Por favor, ingrese un nombre para la Categoría",
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_modificarCategoria').serialize();
                var url = 'includes/producto/categoria/modificarCategoria.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_modificarCategoria").modal("hide");
                        $("#info").html(form);
                        verCategoria();
                        $('#form_modificarCategoria')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    $('#btn_eliminarCategoria').on('click', function () {
        $('#form_eliminarCategoria').validate({
            rules: {
                E_CATEGORIA_NOMBRE: {
                    required: true,
                    rangelength: [2, 255]
                }
            },
            messages: {
                E_CATEGORIA_NOMBRE: {
                    required: "Por favor, ingrese un nombre para la Categoría",
                    rangelength: "Por favor, ingrese un valor entre 2 y 30 caracteres"
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_eliminarCategoria').serialize();
                var url = 'includes/producto/categoria/eliminarCategoria.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        $("#modal_eliminarCategoria").modal("hide");
                        $("#info").html(form);
                        verCategoria();
                        $('#form_eliminarCategoria')[0].reset();
                        function cerrar() {
                            $("#mensaje").fadeOut(400);
                        }
                        setTimeout(cerrar, 2000);
                    }
                });
                return;
            }
        });
    });
    /*
     * REPORTE
     */
    $('#btn_filtrarReporte').on('click', function () {
        $('#form_filtrarReporte').validate({
            rules: {
                R_REPORTE_FECHA_INICIO: {
                    required: true
                },
                R_REPORTE_FECHA_FIN: {
                    required: true
                },
                R_REPORTE_ESTADO: {
                    required: true
                }
            },
            messages: {
                R_REPORTE_FECHA_INICIO: {
                    required: "Por favor, ingrese una fecha de inicio."
                },
                R_REPORTE_FECHA_FIN: {
                    required: "Por favor, ingrese una fecha de fin."
                },
                R_REPORTE_ESTADO: {
                    required: "Por favor, seleccione un estado."
                }
            },
            submitHandler: function (form) {
                var dataString = $('#form_filtrarReporte').serialize();
                var url = 'includes/reporte/verReporte.php';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: dataString,
                    success: function (form) {
                        var datos = eval(form);
                        $("#verReporte").html(datos);
                    }
                });
                return false;
            }
        });
    });
});

/*
 * FORMULARIOS PRODUCTO
 */
function llamarFormularioEditarProducto(idProducto) {
    $('#form_update_product')[0].reset();
    var url = 'php/llamarRegistroProducto.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idProducto,
        success: function (valores) {
            var datos = eval(valores);
            $('#M_ID').val(idProducto);
            $('#M_NOMBRE').val(datos[1]);
            $('#M_DESCRIPCION').val(datos[2]);
            $('#M_PRECIO_COSTO').val(datos[3]);
            $('#M_PRECIO_VENTA').val(datos[4]);
            $('#M_ID_ESTADO').val(datos[5]);
            $('#M_ID_CATEGORIA').val(datos[6]);
            $('#M_ID_IMPUESTO').val(datos[7]);
            $('#M_ID_MARCA').val(datos[8]);
            $('#M_CANT_ACTUAL').val(datos[9]);
            $('#modificarProducto').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

function llamarFormularioEliminarProducto(idProducto) {
    $('#form_eliminarProducto')[0].reset();
    var url = 'php/llamarRegistroProducto.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idProducto,
        success: function (valores) {
            var datos = eval(valores);
            $('#E_PRODUCTO_ID').val(idProducto);
            $('#E_PRODUCTO_NOMBRE').val(datos[1]);
            $('#modal_eliminarProducto').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

/*
 * FORMULARIOS PEDIDO
 */
function llamarFormularioEntregarPedido(idPedido) {
    $('#form_entregarPedido')[0].reset();
    var url = 'php/llamarRegistroPedido.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idPedido,
        success: function (valores) {
            var datos = eval(valores);
            $('#P_PEDIDO_ID').val(idPedido);
            $('#P_PEDIDO_ID_CLIENTE').val(datos[1]);
            $('#modal_entregarPedido').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}
function llamarFormularioEditarPedido(idPedido) {
    $('#form_modificarPedido')[0].reset();
    var url = 'php/llamarRegistroPedido.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idPedido,
        success: function (valores) {
            var datos = eval(valores);
            $('#M_PEDIDO_ID').val(idPedido);
            $('#M_PEDIDO_ID_CLIENTE').val(datos[1]);
            $('#M_PEDIDO_ID_FUNCIONARIO').val(datos[2]);
            $('#M_PEDIDO_TIEMPO_RECEPCION').val(datos[3]);
            $('#M_PEDIDO_FECHA_ENTREGA').val(datos[4]);
            $('#M_PEDIDO_HORA_ENTREGA').val(datos[5]);
            $('#M_PEDIDO_ID_COND_VENTA').val(datos[6]);
            $('#M_PEDIDO_DIRECCION').val(datos[7]);
            $('#M_PEDIDO_ESTADO').val(datos[8]);
            $('#M_PEDIDO_OBSERVACION').val(datos[9]);
            $('#M_PEDIDO_ID_PRODUCTO').val(datos[10]);
            $('#M_PEDIDO_CANT').val(datos[11]);
            $('#M_PEDIDO_PRECIO').val(datos[12]);
            $('#M_PEDIDO_DESCUENTO').val(datos[13]);
            $('#M_PEDIDO_ID_DETALLE').val(datos[14]);
            $('#modal_modificarPedido').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}
function llamarFormularioEliminarPedido(idPedido) {
    var url = 'includes/pedido/eliminarPedido.php';
    var pregunta = confirm("¿Esta seguro que desea eliminar este pedido?");
    if (pregunta == true) {
        $.ajax({
            type: 'POST',
            url: url,
            data: "E_PEDIDO_ID=" + idPedido,
            success: function (form) {
                $("#info").html(form);
                controlarEstadoPedidos();
                function cerrar() {
                    $("#mensaje").fadeOut(400);
                }
                setTimeout(cerrar, 2000);
            }
        });
        return;
    } else {
        return;
    }
}

/*
 * FORMULARIOS CLIENTE
 */
function llamarFormularioEditarCliente(idCliente) {
    $('#form_modificarCliente')[0].reset();
    var url = 'php/llamarRegistroCliente.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idCliente,
        success: function (valores) {
            var datos = eval(valores);
            $('#M_CLIENTE_ID').val(datos[0]);
            $('#M_CLIENTE_NOMBRE').val(datos[1]);
            $('#M_CLIENTE_APELLIDO').val(datos[2]);
            $('#M_CLIENTE_RUC_CI').val(datos[3]);
            $('#M_CLIENTE_RUC_ID').val(datos[4]);
            $('#M_CLIENTE_TELEFONO').val(datos[5]);
            $('#M_CLIENTE_ID_CATEGORIA').val(datos[6]);
            $('#M_CLIENTE_ID_TIPO').val(datos[7]);
            $('#M_CLIENTE_EMAIL').val(datos[8]);
            $('#M_CLIENTE_PAGWEB').val(datos[9]);
            $('#M_CLIENTE_DIRECCION').val(datos[10]);
            $('#M_CLIENTE_OBSERVACION').val(datos[11]);
            $('#modal_modificarCliente').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}
function llamarFormularioEliminarCliente(idCliente) {
    $('#form_eliminarCliente')[0].reset();
    var url = 'php/llamarRegistroCliente.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idCliente,
        success: function (valores) {
            var datos = eval(valores);
            $('#E_CLIENTE_ID').val(idCliente);
            $('#E_CLIENTE_NOMBRE').val(datos[1]);
            $('#E_CLIENTE_RUC_CI').val(datos[3]);
            $('#modal_eliminarCliente').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

/*
 * FORMULARIOS MARCA
 */
function llamarFormularioEditarMarca(idMarca) {
    $('#form_modificarMarca')[0].reset();
    var url = 'php/llamarRegistroMarca.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idMarca,
        success: function (valores) {
            var datos = eval(valores);
            $('#M_MARCA_ID').val(idMarca);
            $('#M_MARCA_NOMBRE').val(datos[1]);
            $('#modal_modificarMarca').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

function llamarFormularioEliminarMarca(idMarca) {
    $('#form_eliminarMarca')[0].reset();
    var url = 'php/llamarRegistroMarca.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idMarca,
        success: function (valores) {
            var datos = eval(valores);
            $('#E_MARCA_ID').val(idMarca);
            $('#E_MARCA_NOMBRE').val(datos[1]);
            $('#modal_eliminarMarca').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

/*
 * FORMULARIOS CATEGORIA
 */
function llamarFormularioEditarCategoria(idCategoria) {
    $('#form_modificarCategoria')[0].reset();
    var url = 'php/llamarRegistroCategoria.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idCategoria,
        success: function (valores) {
            var datos = eval(valores);
            $('#M_CATEGORIA_ID').val(idCategoria);
            $('#M_CATEGORIA_NOMBRE').val(datos[1]);
            $('#modal_modificarCategoria').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

function llamarFormularioEliminarCategoria(idCategoria) {
    $('#form_eliminarCategoria')[0].reset();
    var url = 'php/llamarRegistroCategoria.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: 'id=' + idCategoria,
        success: function (valores) {
            var datos = eval(valores);
            $('#E_CATEGORIA_ID').val(idCategoria);
            $('#E_CATEGORIA_NOMBRE').val(datos[1]);
            $('#modal_eliminarCategoria').modal({
                show: true,
                backdrop: 'static'
            });
        }
    });
    return;
}

/*
 * CONTROLAR PEDIDOS
 */
function controlarEstadoPedidos() {
    var url = 'php/controlarEstadoPedido.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (form) {
            $("#info").html(form);
            verPedido();
        }
    });
    return;
}

/*
 * VER DATOS
 */
function verProducto() {
    var url = 'includes/producto/verProducto.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (data) {
            var array = eval(data);
            $("#verProducto").html(array[0]);
        }
    });
    return false;
}

function verPedido() {
    var url = 'includes/pedido/verPedido.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (data) {
            var array = eval(data);
            $("#verPedido").html(array[0]);
        }
    });
    return false;
}

function verFuncionario() {
    var url = 'includes/funcionario/verFuncionario.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (data) {
            var array = eval(data);
            $("#verFuncionario").html(array[0]);
        }
    });
    return false;
}

function verMarca() {
    var url = 'includes/producto/marca/verMarca.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (data) {
            var array = eval(data);
            $("#verMarca").html(array[0]);
        }
    });
    return false;
}

function verCategoria() {
    var url = 'includes/producto/categoria/verCategoria.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (data) {
            var array = eval(data);
            $("#verCategoria").html(array[0]);
        }
    });
    return false;
}

function verCliente() {
    var url = 'includes/cliente/verCliente.php';
    $.ajax({
        type: 'POST',
        url: url,
        success: function (data) {
            var array = eval(data);
            $("#verCliente").html(array[0]);
        }
    });
    return false;
}

function cargarDatos() {
    controlarEstadoPedidos();
    verCliente();
    verFuncionario();
    verProducto();
    verMarca();
    verCategoria();
}