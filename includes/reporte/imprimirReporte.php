<?php
define('root', $_SERVER['DOCUMENT_ROOT'] . '/Digicolors/');
include(root . 'includes/validador.php');
include(root . 'conexion/conexion.php');

$PEDIDO_ESTADO = $_GET['estado'];
$PEDIDO_ID_CLIENTE = $_GET['cliente'];

$date_recepcion = date_create($_GET['d'] );
$date_entrega = date_create($_GET['h'] );
$PEDIDO_TIEMPO_ENTREGA = date_format($date_entrega, 'Y/m/d H:i:s');
$PEDIDO_TIEMPO_RECEPCION = date_format($date_recepcion, 'Y/m/d H:i:s');

$sql = "SELECT peca.id_pedido_cabecera \"id\", concat(cliente.nombre,' ',cliente.apellido)\"cliente\", tiempo_recepcion, tiempo_entrega, "
        . "(select pedido_estado.descripcion from pedido_estado where pedido_estado.id_pedido_estado = peca.id_pedido_estado)\"estado\", "
        . "(select prod.nombre from producto prod where prod.id_producto = pede.id_producto) \"producto\", "
        . "(select sum(pede.cantidad*(pede.precio-(pede.precio*pede.descuento)/100)) from pedido_detalle pede where pede.id_pedido_cabecera = peca.id_pedido_cabecera)  \"total\" "
        . "FROM pedido_cabecera peca, pedido_detalle pede, cliente "
        . "WHERE peca.id_pedido_cabecera = pede.id_pedido_cabecera "
        . "AND peca.id_cliente = cliente.id_cliente "
        . "AND peca.tiempo_recepcion BETWEEN :pedido_tiempo_recepcion AND :pedido_tiempo_entrega ";
if ($PEDIDO_ESTADO == 0) {
    $sql = $sql . "and peca.id_pedido_estado in (1,2,3,4) ";
} else {
    $sql = $sql . "and peca.id_pedido_estado = :pedido_estado ";
}
if ($PEDIDO_ID_CLIENTE != 0) {
    $sql = $sql . "and peca.id_cliente = :pedido_id_cliente";
}

$stmt = $conex->prepare($sql);
if ($PEDIDO_ESTADO == 0 && $PEDIDO_ID_CLIENTE == 0) {
    $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA]);
} elseif ($PEDIDO_ESTADO != 0 && $PEDIDO_ID_CLIENTE == 0) {
    $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA, $PEDIDO_ESTADO]);
} elseif ($PEDIDO_ESTADO == 0 && $PEDIDO_ID_CLIENTE != 0) {
    $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA, $PEDIDO_ID_CLIENTE]);
} elseif ($PEDIDO_ESTADO != 0 && $PEDIDO_ID_CLIENTE != 0) {
    $stmt->execute([$PEDIDO_TIEMPO_RECEPCION, $PEDIDO_TIEMPO_ENTREGA, $PEDIDO_ESTADO, $PEDIDO_ID_CLIENTE]);
}
$resultado_pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

function ObtenerFuncionario($id) {
    global $conex;
    $SQL = "SELECT * FROM funcionario WHERE funcionario.id_funcionario = :id";
    $stmt = $conex->prepare($SQL);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $resultado = $row['nombre'];
    $stmt->closeCursor();
    return $resultado;
}

function obtenerEstado($id) {
    switch ($id) {
        case 1:
            return 'Pendiente';
        case 2:
            return 'Entregado';
        case 3:
            return 'Cancelado';
        case 4:
            return 'Aplazado';
        default:
            return 'Sin estado';
    }
}

function fechaNormal($fecha) {
    $nfecha = date('Y-m-d', strtotime($fecha));
    return $nfecha;
}

$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ( (isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
    'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
    'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
    'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
    'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
    'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
    'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
    'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
    'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');

if (in_array($mobile_ua, $mobile_agents)) {
    $mobile_browser++;
}

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
        $tablet_browser++;
    }
}
?>
<html><head>
        <meta charset="UTF-8">

        <style>

            *,
            *:after,
            *:before {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            /* -- Demo style ------------------------------- */
            html,
            body {
                position: relative;
                min-height: 100%;
                height: 100%;
            }
            html {
                position: relative;
                overflow-x: hidden;
                margin: 16px;
                padding: 0;
                min-height: 100%;
                font-size: 62.5%;
            }
            body {
                font-family: 'RobotoDraft', 'Roboto', 'Helvetica Neue, Helvetica, Arial', sans-serif;
                font-style: normal;
                font-weight: 300;
                font-size: 1.4rem;
                line-height: 2rem;
                letter-spacing: 0.01rem;
                color: #212121;
                background-color: #f5f5f5;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
            }
            #demo {
                margin: 20px auto;
            }
            #demo h1 {
                font-size: 2.4rem;
                line-height: 3.2rem;
                letter-spacing: 0;
                font-weight: 300;
                color: #212121;
                text-transform: inherit;
                margin-bottom: 1rem;
                text-align: center;
            }
            #demo h2 {
                font-size: 1.5rem;
                line-height: 2.8rem;
                letter-spacing: 0.01rem;
                font-weight: 400;
                color: #212121;
                text-align: center;
            }
            .shadow-z-1 {
                -webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
                -moz-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
            }
            /* -- Material Design Table style -------------- */
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 2rem;
                background-color: #fff;
            }
            .table > thead > tr,
            .table > tbody > tr,
            .table > tfoot > tr {
                -webkit-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
                transition: all 0.3s ease;
            }
            .table > thead > tr > th,
            .table > tbody > tr > th,
            .table > tfoot > tr > th,
            .table > thead > tr > td,
            .table > tbody > tr > td,
            .table > tfoot > tr > td {
                text-align: left;
                padding: 1.6rem;
                vertical-align: top;
                border-top: 0;
                -webkit-transition: all 0.3s ease;
                -o-transition: all 0.3s ease;
                transition: all 0.3s ease;
            }
            .table > thead > tr > th {
                font-weight: 400;
                color: #757575;
                vertical-align: bottom;
                border-bottom: 1px solid rgba(0, 0, 0, 0.12);
            }
            .table > caption + thead > tr:first-child > th,
            .table > colgroup + thead > tr:first-child > th,
            .table > thead:first-child > tr:first-child > th,
            .table > caption + thead > tr:first-child > td,
            .table > colgroup + thead > tr:first-child > td,
            .table > thead:first-child > tr:first-child > td {
                border-top: 0;
            }
            .table > tbody + tbody {
                border-top: 1px solid rgba(0, 0, 0, 0.12);
            }
            .table .table {
                background-color: #fff;
            }
            .table .no-border {
                border: 0;
            }
            .table-condensed > thead > tr > th,
            .table-condensed > tbody > tr > th,
            .table-condensed > tfoot > tr > th,
            .table-condensed > thead > tr > td,
            .table-condensed > tbody > tr > td,
            .table-condensed > tfoot > tr > td {
                padding: 0.8rem;
            }
            .table-bordered {
                border: 0;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > tbody > tr > td,
            .table-bordered > tfoot > tr > td {
                border: 0;
                border-bottom: 1px solid #e0e0e0;
            }
            .table-bordered > thead > tr > th,
            .table-bordered > thead > tr > td {
                border-bottom-width: 2px;
            }
            .table-striped > tbody > tr:nth-child(odd) > td,
            .table-striped > tbody > tr:nth-child(odd) > th {
                background-color: #f5f5f5;
            }
            .table-hover > tbody > tr:hover > td,
            .table-hover > tbody > tr:hover > th {
                background-color: rgba(0, 0, 0, 0.12);
            }
            @media screen and (max-width: 768px) {
                .table-responsive-vertical > .table {
                    margin-bottom: 0;
                    background-color: transparent;
                }
                .table-responsive-vertical > .table > thead,
                .table-responsive-vertical > .table > tfoot {
                    display: none;
                }
                .table-responsive-vertical > .table > tbody {
                    display: block;
                }
                .table-responsive-vertical > .table > tbody > tr {
                    display: block;
                    border: 1px solid #e0e0e0;
                    border-radius: 2px;
                    margin-bottom: 1.6rem;
                }
                .table-responsive-vertical > .table > tbody > tr > td {
                    background-color: #fff;
                    display: block;
                    vertical-align: middle;
                    text-align: right;
                }
                .table-responsive-vertical > .table > tbody > tr > td[data-title]:before {
                    content: attr(data-title);
                    float: left;
                    font-size: inherit;
                    font-weight: 400;
                    color: #757575;
                }
                .table-responsive-vertical.shadow-z-1 {
                    -webkit-box-shadow: none;
                    -moz-box-shadow: none;
                    box-shadow: none;
                }
                .table-responsive-vertical.shadow-z-1 > .table > tbody > tr {
                    border: none;
                    -webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
                    -moz-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
                }
                .table-responsive-vertical > .table-bordered {
                    border: 0;
                }
                .table-responsive-vertical > .table-bordered > tbody > tr > td {
                    border: 0;
                    border-bottom: 1px solid #e0e0e0;
                }
                .table-responsive-vertical > .table-bordered > tbody > tr > td:last-child {
                    border-bottom: 0;
                }
                .table-responsive-vertical > .table-striped > tbody > tr > td,
                .table-responsive-vertical > .table-striped > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical > .table-striped > tbody > tr > td:nth-child(odd) {
                    background-color: #f5f5f5;
                }
                .table-responsive-vertical > .table-hover > tbody > tr:hover > td,
                .table-responsive-vertical > .table-hover > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical > .table-hover > tbody > tr > td:hover {
                    background-color: rgba(0, 0, 0, 0.12);
                }
            }
            .table-striped.table-mc-red > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-red > tbody > tr:nth-child(odd) > th {
                background-color: #fde0dc;
            }
            .table-hover.table-mc-red > tbody > tr:hover > td,
            .table-hover.table-mc-red > tbody > tr:hover > th {
                background-color: #f9bdbb;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-red > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-red > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-red > tbody > tr > td:nth-child(odd) {
                    background-color: #fde0dc;
                }
                .table-responsive-vertical .table-hover.table-mc-red > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-red > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-red > tbody > tr > td:hover {
                    background-color: #f9bdbb;
                }
            }
            .table-striped.table-mc-pink > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-pink > tbody > tr:nth-child(odd) > th {
                background-color: #fce4ec;
            }
            .table-hover.table-mc-pink > tbody > tr:hover > td,
            .table-hover.table-mc-pink > tbody > tr:hover > th {
                background-color: #f8bbd0;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-pink > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-pink > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-pink > tbody > tr > td:nth-child(odd) {
                    background-color: #fce4ec;
                }
                .table-responsive-vertical .table-hover.table-mc-pink > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-pink > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-pink > tbody > tr > td:hover {
                    background-color: #f8bbd0;
                }
            }
            .table-striped.table-mc-purple > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-purple > tbody > tr:nth-child(odd) > th {
                background-color: #f3e5f5;
            }
            .table-hover.table-mc-purple > tbody > tr:hover > td,
            .table-hover.table-mc-purple > tbody > tr:hover > th {
                background-color: #e1bee7;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-purple > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-purple > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-purple > tbody > tr > td:nth-child(odd) {
                    background-color: #f3e5f5;
                }
                .table-responsive-vertical .table-hover.table-mc-purple > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-purple > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-purple > tbody > tr > td:hover {
                    background-color: #e1bee7;
                }
            }
            .table-striped.table-mc-deep-purple > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-deep-purple > tbody > tr:nth-child(odd) > th {
                background-color: #ede7f6;
            }
            .table-hover.table-mc-deep-purple > tbody > tr:hover > td,
            .table-hover.table-mc-deep-purple > tbody > tr:hover > th {
                background-color: #d1c4e9;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-deep-purple > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-deep-purple > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-deep-purple > tbody > tr > td:nth-child(odd) {
                    background-color: #ede7f6;
                }
                .table-responsive-vertical .table-hover.table-mc-deep-purple > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-deep-purple > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-deep-purple > tbody > tr > td:hover {
                    background-color: #d1c4e9;
                }
            }
            .table-striped.table-mc-indigo > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-indigo > tbody > tr:nth-child(odd) > th {
                background-color: #e8eaf6;
            }
            .table-hover.table-mc-indigo > tbody > tr:hover > td,
            .table-hover.table-mc-indigo > tbody > tr:hover > th {
                background-color: #c5cae9;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-indigo > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-indigo > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-indigo > tbody > tr > td:nth-child(odd) {
                    background-color: #e8eaf6;
                }
                .table-responsive-vertical .table-hover.table-mc-indigo > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-indigo > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-indigo > tbody > tr > td:hover {
                    background-color: #c5cae9;
                }
            }
            .table-striped.table-mc-blue > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-blue > tbody > tr:nth-child(odd) > th {
                background-color: #e7e9fd;
            }
            .table-hover.table-mc-blue > tbody > tr:hover > td,
            .table-hover.table-mc-blue > tbody > tr:hover > th {
                background-color: #d0d9ff;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-blue > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-blue > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-blue > tbody > tr > td:nth-child(odd) {
                    background-color: #e7e9fd;
                }
                .table-responsive-vertical .table-hover.table-mc-blue > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-blue > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-blue > tbody > tr > td:hover {
                    background-color: #d0d9ff;
                }
            }
            .table-striped.table-mc-light-blue > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-light-blue > tbody > tr:nth-child(odd) > th {
                background-color: #e1f5fe;
            }
            .table-hover.table-mc-light-blue > tbody > tr:hover > td,
            .table-hover.table-mc-light-blue > tbody > tr:hover > th {
                background-color: #b3e5fc;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-light-blue > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-light-blue > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-light-blue > tbody > tr > td:nth-child(odd) {
                    background-color: #e1f5fe;
                }
                .table-responsive-vertical .table-hover.table-mc-light-blue > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-light-blue > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-light-blue > tbody > tr > td:hover {
                    background-color: #b3e5fc;
                }
            }
            .table-striped.table-mc-cyan > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-cyan > tbody > tr:nth-child(odd) > th {
                background-color: #e0f7fa;
            }
            .table-hover.table-mc-cyan > tbody > tr:hover > td,
            .table-hover.table-mc-cyan > tbody > tr:hover > th {
                background-color: #b2ebf2;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-cyan > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-cyan > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-cyan > tbody > tr > td:nth-child(odd) {
                    background-color: #e0f7fa;
                }
                .table-responsive-vertical .table-hover.table-mc-cyan > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-cyan > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-cyan > tbody > tr > td:hover {
                    background-color: #b2ebf2;
                }
            }
            .table-striped.table-mc-teal > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-teal > tbody > tr:nth-child(odd) > th {
                background-color: #e0f2f1;
            }
            .table-hover.table-mc-teal > tbody > tr:hover > td,
            .table-hover.table-mc-teal > tbody > tr:hover > th {
                background-color: #b2dfdb;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-teal > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-teal > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-teal > tbody > tr > td:nth-child(odd) {
                    background-color: #e0f2f1;
                }
                .table-responsive-vertical .table-hover.table-mc-teal > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-teal > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-teal > tbody > tr > td:hover {
                    background-color: #b2dfdb;
                }
            }
            .table-striped.table-mc-green > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-green > tbody > tr:nth-child(odd) > th {
                background-color: #d0f8ce;
            }
            .table-hover.table-mc-green > tbody > tr:hover > td,
            .table-hover.table-mc-green > tbody > tr:hover > th {
                background-color: #a3e9a4;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-green > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-green > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-green > tbody > tr > td:nth-child(odd) {
                    background-color: #d0f8ce;
                }
                .table-responsive-vertical .table-hover.table-mc-green > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-green > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-green > tbody > tr > td:hover {
                    background-color: #a3e9a4;
                }
            }
            .table-striped.table-mc-light-green > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-light-green > tbody > tr:nth-child(odd) > th {
                background-color: #f1f8e9;
            }
            .table-hover.table-mc-light-green > tbody > tr:hover > td,
            .table-hover.table-mc-light-green > tbody > tr:hover > th {
                background-color: #dcedc8;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-light-green > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-light-green > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-light-green > tbody > tr > td:nth-child(odd) {
                    background-color: #f1f8e9;
                }
                .table-responsive-vertical .table-hover.table-mc-light-green > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-light-green > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-light-green > tbody > tr > td:hover {
                    background-color: #dcedc8;
                }
            }
            .table-striped.table-mc-lime > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-lime > tbody > tr:nth-child(odd) > th {
                background-color: #f9fbe7;
            }
            .table-hover.table-mc-lime > tbody > tr:hover > td,
            .table-hover.table-mc-lime > tbody > tr:hover > th {
                background-color: #f0f4c3;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-lime > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-lime > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-lime > tbody > tr > td:nth-child(odd) {
                    background-color: #f9fbe7;
                }
                .table-responsive-vertical .table-hover.table-mc-lime > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-lime > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-lime > tbody > tr > td:hover {
                    background-color: #f0f4c3;
                }
            }
            .table-striped.table-mc-yellow > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-yellow > tbody > tr:nth-child(odd) > th {
                background-color: #fffde7;
            }
            .table-hover.table-mc-yellow > tbody > tr:hover > td,
            .table-hover.table-mc-yellow > tbody > tr:hover > th {
                background-color: #fff9c4;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-yellow > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-yellow > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-yellow > tbody > tr > td:nth-child(odd) {
                    background-color: #fffde7;
                }
                .table-responsive-vertical .table-hover.table-mc-yellow > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-yellow > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-yellow > tbody > tr > td:hover {
                    background-color: #fff9c4;
                }
            }
            .table-striped.table-mc-amber > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-amber > tbody > tr:nth-child(odd) > th {
                background-color: #fff8e1;
            }
            .table-hover.table-mc-amber > tbody > tr:hover > td,
            .table-hover.table-mc-amber > tbody > tr:hover > th {
                background-color: #ffecb3;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-amber > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-amber > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-amber > tbody > tr > td:nth-child(odd) {
                    background-color: #fff8e1;
                }
                .table-responsive-vertical .table-hover.table-mc-amber > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-amber > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-amber > tbody > tr > td:hover {
                    background-color: #ffecb3;
                }
            }
            .table-striped.table-mc-orange > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-orange > tbody > tr:nth-child(odd) > th {
                background-color: #fff3e0;
            }
            .table-hover.table-mc-orange > tbody > tr:hover > td,
            .table-hover.table-mc-orange > tbody > tr:hover > th {
                background-color: #ffe0b2;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-orange > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-orange > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-orange > tbody > tr > td:nth-child(odd) {
                    background-color: #fff3e0;
                }
                .table-responsive-vertical .table-hover.table-mc-orange > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-orange > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-orange > tbody > tr > td:hover {
                    background-color: #ffe0b2;
                }
            }
            .table-striped.table-mc-deep-orange > tbody > tr:nth-child(odd) > td,
            .table-striped.table-mc-deep-orange > tbody > tr:nth-child(odd) > th {
                background-color: #fbe9e7;
            }
            .table-hover.table-mc-deep-orange > tbody > tr:hover > td,
            .table-hover.table-mc-deep-orange > tbody > tr:hover > th {
                background-color: #ffccbc;
            }
            @media screen and (max-width: 767px) {
                .table-responsive-vertical .table-striped.table-mc-deep-orange > tbody > tr > td,
                .table-responsive-vertical .table-striped.table-mc-deep-orange > tbody > tr:nth-child(odd) {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-striped.table-mc-deep-orange > tbody > tr > td:nth-child(odd) {
                    background-color: #fbe9e7;
                }
                .table-responsive-vertical .table-hover.table-mc-deep-orange > tbody > tr:hover > td,
                .table-responsive-vertical .table-hover.table-mc-deep-orange > tbody > tr:hover {
                    background-color: #fff;
                }
                .table-responsive-vertical .table-hover.table-mc-deep-orange > tbody > tr > td:hover {
                    background-color: #ffccbc;
                }
            }

        </style> 
    </head>

    <body translate="no">
        <div id="demo">
            <h1>Digicolors</h1>

            <h2>Reporte de pedidos</h2>
            <h2><strong>Desde:</strong> <?php echo strftime('%d de %B del %Y', strtotime($PEDIDO_TIEMPO_RECEPCION)); ?> <strong>Hasta:</strong> <?php echo strftime('%d de %B del %Y', strtotime($PEDIDO_TIEMPO_ENTREGA)); ?></h2>
            <div class="table-responsive-vertical shadow-z-1">
                <!-- Table starts here -->
                <table id="table" class="table table-hover table-mc-light-blue table-bordered">
                    <thead>
                        <tr>
                            <th width="70">ID</th>
                            <th>Cliente</th>
                            <th>Producto/Servicio</th>
                            <th>Tiempo recepción</th>
                            <th>Tiempo entrega</th>
                            <th>Sub-Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sumatotal=0;
                        $tabla='';
                        foreach ($resultado_pedidos as $row => $link) {
                                $tabla = $tabla . '
                                <tr class="odd gradeX">
                                <td>' . $link['id'] . '</td>
                                <td>' . $link['cliente'] . '</td>
                                <td>' . $link['producto'] . '</td>
                                <td>' . strftime('%d/%b/%y %H:%M', strtotime($link['tiempo_recepcion'])) . '</td>
                                <td>' . strftime('%d/%b/%y %H:%M', strtotime($link['tiempo_entrega'])) . '</td>
                                <td>' . number_format($link['total'], 0, ".", ".") . '</td>'
                        ?><?php

                                if ($link['estado'] == 'Pendiente') {
                                    $tabla = $tabla . '<td> <span class="badge badge-info verde">' . $link['estado'] . '</span></td>';
                                } elseif ($link['estado'] == 'Entregado') {
                                    $tabla = $tabla . '<td> <span class="badge badge-info">' . $link['estado'] . '</span></td>';
                                } elseif ($link['estado'] == 'Cancelado') {
                                    $tabla = $tabla . '<td> <span class="badge badge-info naranja">' . $link['estado'] . '</span></td>';
                                } elseif ($link['estado'] == 'Aplazado') {
                                    $tabla = $tabla . '<td> <span class="badge badge-info rojo">' . $link['estado'] . '</span></td>';
                                }
                        ?><?php

                                '</tr>
                                             ';
                                $sumatotal = $sumatotal + $link['total'];
                            }echo ($tabla); ?>
                        <tr>

                            <th colspan="4"></th>
                            <th><strong>TOTALES</strong></th>
                            <th style="text-align:right">Gs. <strong><?php echo number_format($sumatotal, 0, ',', ".") ?></strong></th>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body></html