$(function () {
    var timeSlide = 1000;
    $('#form_login').validate({
        rules: {
            L_USER: {
                required: true,
                rangelength: [2, 10]
            },
            L_PASSWORD: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            L_USER: {
                required: "Por favor, ingrese usuario de login.",
                rangelength: "Mínino 2 Y máximo 10 caracteres."
            },
            L_PASSWORD: {
                required: "Ingrese su contraseña.",
                minlength: "Mínino 6 caracteres."
            }
        },
        submitHandler: function (form) {
            $('.alert-success, .alert-danger, .alert-info, .alert-warning').slideUp(timeSlide);

            var dataString = $('#form_login').serialize();
            var url = 'includes/login/loginController.php';
            var urlPREV = $('#prevURL').val();
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                success: function (msj) {
                    if (msj == 1) {
                        $(form).find("#btn_ingresar").html('Ingresando...').prop('disabled', 'disabled');
                        $('#alertBoxes').html('<div class="alert alert-success"></div>');
                        $('.alert-success').hide(0).html("Espera un momento...");
                        $('.alert-success').slideDown(timeSlide);
                            if(urlPREV == 0) {
                                setTimeout(function () {
                                    window.location.href = "index.php";
                                }, (timeSlide + 1000));   
                            }else{
                                setTimeout(function () {
                                    window.location.href = urlPREV;
                                }, (timeSlide + 1000));  
                            }
                    } else {
                        $('#alertBoxes').html('<div class="alert alert-danger"></div>');
                        $('.alert-danger').hide(0).html("Error al intentar acceder");
                        $('.alert-danger').slideDown(timeSlide).slideUp(timeSlide * 3);
                    }
                }
            });
        }
    });


});
