<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/PacientesModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) != false ? filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT) : false;
$nombre = isset($data['nombre']) != false ? filter_var($data['nombre'], FILTER_SANITIZE_STRING) : false;
$apellido = isset($data['apellido']) != false ? filter_var($data['apellido'], FILTER_SANITIZE_STRING) : false;
$genero = isset($data['genero']) != false ? filter_var($data['genero'], FILTER_SANITIZE_NUMBER_INT) : false;
$fechaNacimiento = isset($data['fechaNacimiento']) != false ? filter_var($data['fechaNacimiento'], FILTER_SANITIZE_STRING) : false;
$dni = isset($data['dni']) != false ? filter_var($data['dni'], FILTER_SANITIZE_STRING) : false;
$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;


/*git 
 * CODIGO ERRORES:
 * satisfactorio: Exito.
 * error: Hubo un error.
 */

if ($accion == 'obtenerPacientes') {
    $paciente = new PacientesModelo();

    try {
        $respuesta = $paciente->obtenerPacientes();
    } catch (Exception $e) {
        $respuesta = array(
            'estado' => 'error'
        );
    }

    die(json_encode($respuesta));
}

if ($accion == 'insertarPaciente') {
    if ($nombre == false || $apellido == false || $fechaNacimiento == false || $dni == false || $genero == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $paciente = new PacientesModelo();
        $paciente->setNombre($nombre);
        $paciente->setApellido($apellido);
        $paciente->setFechaNacimiento($fechaNacimiento);
        $paciente->setDni($dni);
        $paciente->setGenero($genero);

        try {
            $respuesta = $paciente->insertarPaciente();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error1'
            );
        }

        die(json_encode($respuesta));
    }
}

if ($accion == 'eliminarPaciente') {
    if ($id == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $paciente = new PacientesModelo();
        $paciente->setId($id);

        try {
            $respuesta = $paciente->eliminarPaciente();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}