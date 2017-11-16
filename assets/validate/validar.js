$(function () {
    var timeSlide = 1000;

    $('#accesoadmin').validate({
        rules: {
            "email": {
                "required": true,
                "email": true,
            },
            "password": {
                "required": true,
                "minlength": "6",
            },
        },
        messages: {
            "email": {
                "required": "Ingrese su e-mail",
                "email": "E-mail inválido",
            },
            "password": {
                "required": "Ingrese su contraseña",
                "minlength": "Mínino 6 caracteres",
            },
        },
        submitHandler: function (form) {
            $('.alert-success, .alert-danger, .alert-info, .alert-warning').slideUp(timeSlide);

            var dataString = 'email=' + $('#email').val() + '&password=' + $('#password').val() + '&formid=1';
            $.ajax({
                type: "POST",
                url: "includes/conectar2.php",
                data: dataString,
                success: function (msj) {
                    if (msj == 1) {
                        $(form).find("#btn-ingresar").html('Ingresando...').prop('disabled', 'disabled');
                        $('#alertBoxes').html('<div class="alert alert-success"></div>');
                        $('.alert-success').hide(0).html("Espera un momento...");
                        $('.alert-success').slideDown(timeSlide);
                        setTimeout(function () {
                            window.location.href = "home.php";
                        }, (timeSlide + 1000));
                    } else {
                        /*$('#alertBoxes').html('<div class="alert alert-danger"></div>');
                         $('.alert-danger').hide(0).html("Error al intentar acceder");
                         $('.alert-success').slideDown(timeSlide);*/
                        $('#alertBoxes').html('<div class="alert alert-danger"></div>');
                        $('.alert-danger').hide(0).html("Error al intentar acceder");
                        $('.alert-danger').slideDown(timeSlide).slideUp(timeSlide * 3);
                    }
                }
            });
        }
    });


});
