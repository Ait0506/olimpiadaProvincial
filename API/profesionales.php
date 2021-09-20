<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/ProfesionalesModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) != false ? filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT) : false;
$nombre = isset($data['nombre']) != false ? filter_var($data['nombre'], FILTER_SANITIZE_STRING) : false;
$apellido = isset($data['apellido']) != false ? filter_var($data['apellido'], FILTER_SANITIZE_STRING) : false;
$idEspecialidad = isset($data['idEspecialidad']) != false ? filter_var($data['idEspecialidad'], FILTER_SANITIZE_NUMBER_INT) : false;
$fechaNacimiento = isset($data['fechaNacimiento']) != false ? filter_var($data['fechaNacimiento'], FILTER_SANITIZE_STRING) : false;
$dni = isset($data['dni']) != false ? filter_var($data['dni'], FILTER_SANITIZE_STRING) : false;
$password = isset($data['password']) != false ? filter_var($data['password'], FILTER_SANITIZE_STRING) : false;
$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;

/*git 
 * CODIGO ERRORES:
 * satisfactorio: Exito.
 * error: Hubo un error.
 */

if ($accion == 'obtenerProfesionales') {
    $profesional = new ProfesionalesModelo();

    try {
        $respuesta = $profesional->obtenerProfesionales();
    } catch (Exception $e) {
        $respuesta = array(
            'estado' => 'error'
        );
    }

    die(json_encode($respuesta));
}

if ($accion == 'insertarProfesional') {
    if ($nombre == false || $apellido == false || $idEspecialidad == false || $fechaNacimiento == false || $dni == false || $password == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $profesional = new ProfesionalesModelo();
        $profesional->setNombre($nombre);
        $profesional->setApellido($apellido);
        $profesional->setidEspecialidad($idEspecialidad);
        $profesional->setFechaNacimiento($fechaNacimiento);
        $profesional->setDni($dni);
        $profesional->setPassword($password);

        try {
            $respuesta = $profesional->insertarProfesional();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error1'
            );
        }

        die(json_encode($respuesta));
    }
}

if ($accion == 'eliminarProfesional') {
    if ($id == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $profesional = new ProfesionalesModelo();
        $profesional->setId($id);

        try {
            $respuesta = $profesional->eliminarProfesional();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}