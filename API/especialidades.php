<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/EspecialidadesModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) != false ? filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT) : false;
$nombreEspecialidad = isset($data['especialidad']) != false ? filter_var($data['especialidad'], FILTER_SANITIZE_STRING) : false;
$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;

/*git 
 * CODIGO ERRORES:
 * satisfactorio: Exito.
 * error: Hubo un error.
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

if ($accion == 'insertarEspecialidad') {
    if ($nombreEspecialidad == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $especialidad = new EspecialidadesModelo();
        $especialidad->setEspecialidad($nombreEspecialidad);

        try {
            $respuesta = $especialidad->insertarEspecialidad();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}

if ($accion == 'eliminarEspecialidad') {
    if ($id == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $especialidad = new EspecialidadesModelo();
        $especialidad->setId($id);

        try {
            $respuesta = $especialidad->eliminarEspecialidad();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}