<?php

define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');;
include(root . 'conexion/conexion.php');

$loginFormAction = $_SERVER['PHP_SELF'];

if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if ((isset($_POST['login_ingresar'])) && (isset($_POST['login_ingresar']) == 1)) {
    $LOGIN_USER = $_POST['L_USER'];
    $LOGIN_PASSWORD = $_POST['L_PASSWORD'];
    if (!isset($_SESSION)) {
        session_start();
    }
    $sql = 'select * from funcionario, funcionario_rol where funcionario.id_funcionario_rol = funcionario_rol.id_funcionario_rol AND usuario = :usuario and contrasena = :password';
    $stmt = $conex->prepare($sql);
    $stmt->execute([$LOGIN_USER, $LOGIN_PASSWORD]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $loginFoundUser = $stmt->rowCount();

    if ($loginFoundUser) {
        if (PHP_VERSION >= 5.1) {
            session_regenerate_id(TRUE);
        } else {
            session_regenerate_id();
        }
        $_SESSION['MS_USER'] = $LOGIN_USER;
        $_SESSION['MS_USER_ROL_ID'] = $user['id_funcionario_rol'];
        $_SESSION['MS_USER_ROL_NAME'] = $user['descripcion'];
        $_SESSION['MS_USER_ID'] = $user['id_funcionario'];
        $_SESSION['MS_USER_NAME'] = $user['nombre'] . ' ' . $user['apellido'];
        echo 1;
        return;
    }
    echo 2;
}
?>

