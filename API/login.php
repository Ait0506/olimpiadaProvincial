<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/ProfesionalesModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$dni = isset($data['dni']) != false ? filter_var($data['dni'], FILTER_SANITIZE_STRING) : false;
$password = isset($data['password']) != false ? filter_var($data['password'], FILTER_SANITIZE_STRING) : false;
$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;

// $dni = '11';
// $password = 'password';
// $accion = 'iniciarSesion';


/**
 * CODIGO ERRORES:
 * error: Hubo un error.
 * errorInputs: Datos ingresados no validos.
 * errorPassword: Password incorrecta.
 * errorUser: Usuario inexistente.
 */

if ($accion == 'iniciarSesion') {

    if ($dni == false || $password == false) {

        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $profesional = new ProfesionalesModelo();
        $profesional->setDni($dni);
        $profesional->setPassword($password);

        try {
            $respuesta = $profesional->iniciarSesion();
            
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}