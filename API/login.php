<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/ProfesionalesModelo.php';

// $dni = isset($_POST['dni']) != false ? filter_var($_POST['dni'], FILTER_SANITIZE_STRING) : false;
// $password = isset($_POST['password']) != false ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : false;
// $accion = isset($_POST['accion']) != false ? filter_var($_POST['accion'], FILTER_SANITIZE_STRING) : false;

$dni = '25123123';
$password = 'password';
$accion = 'iniciarSesion';

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