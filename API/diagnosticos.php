<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/DiagnosticosModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) != false ? filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT) : false;
$idPaciente = isset($data['idPaciente']) != false ? filter_var($data['idPaciente'], FILTER_SANITIZE_NUMBER_INT) : false;
$idProfesional = isset($data['idProfesional']) != false ? filter_var($data['idProfesional'], FILTER_SANITIZE_NUMBER_INT) : false;
$descripcion = isset($data['descripcion']) != false ? filter_var($data['descripcion'], FILTER_SANITIZE_STRING) : false;
$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;

$id = 9;
$idPaciente = 1;
$idProfesional = 1;
$descripcion = 'diagnostico';
$accion = 'eliminarDiagnostico';

/*git 
 * CODIGO ERRORES:
 * satisfactorio: Exito.
 * error: Hubo un error.
 */

// if ($accion == 'obtenerPacientes') {
//     $paciente = new PacientesModelo();

//     try {
//         $respuesta = $paciente->obtenerPacientes();
//     } catch (Exception $e) {
//         $respuesta = array(
//             'estado' => 'error'
//         );
//     }

//     die(json_encode($respuesta));
// }

if ($accion == 'insertarDiagnostico') {
    if ($idPaciente == false || $idProfesional == false || $descripcion == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $diagnostico = new DiagnosticosModelo();
        $diagnostico->setIdPaciente($idPaciente);
        $diagnostico->setIdProfesional($idProfesional);
        $diagnostico->setDescripcion($descripcion);

        try {
            $respuesta = $diagnostico->insertarDiagnostico();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error1'
            );
        }

        die(json_encode($respuesta));
    }
}

if ($accion == 'eliminarDiagnostico') {
    if ($id == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $diagnostico = new DiagnosticosModelo();
        $diagnostico->setId($id);

        try {
            $respuesta = $diagnostico->eliminarDiagnostico();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}