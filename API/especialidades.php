<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/EspecialidadesModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;

$accion = 'obtenerEspecialidades';


/**
 * CODIGO ERRORES:
 * error: Hubo un error.
 * errorInputs: Datos ingresados no validos.
 * errorPassword: Password incorrecta.
 * errorUser: Usuario inexistente.
 */

if ($accion == 'obtenerEspecialidades') {
    $especialidad = new EspecialidadesModelo();

    try {
        $respuesta = $especialidad->obtenerEspecialidades();
    } catch (Exception $e) {
        $respuesta = array(
            'estado' => 'error'
        );
    }

    die(json_encode($respuesta));
    
}