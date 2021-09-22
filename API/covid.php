<?php

include_once '../configuracion/bd.php';
include_once '../modelos/PadreModelo.php';
include_once '../modelos/CovidModelo.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) != false ? filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT) : false;
$idPaciente = isset($data['idPaciente']) != false ? filter_var($data['idPaciente'], FILTER_SANITIZE_NUMBER_INT) : false;
$internacion = isset($data['internacion']) != false ? filter_var($data['internacion'], FILTER_SANITIZE_NUMBER_INT) : false;
$estadoCovid = isset($data['estadoCovid']) != false ? filter_var($data['estadoCovid'], FILTER_SANITIZE_NUMBER_INT) : false;
$descripcion = isset($data['descripcion']) != false ? filter_var($data['descripcion'], FILTER_SANITIZE_STRING) : false;
$accion = isset($data['accion']) != false ? filter_var($data['accion'], FILTER_SANITIZE_STRING) : false;

$idPaciente = 1;
$internacion = 0;
$estadoCovid = 1;
$descripcion = 'Bien';
$accion = 'insertarCovid';

/*git 
 * CODIGO ERRORES:
 * satisfactorio: Exito.
 * error: Hubo un error.
 */

// if ($accion == 'obtenerDiagnosticos') {
//     $diagnostico = new DiagnosticosModelo();

//     try {
//         $respuesta = $diagnostico->obtenerDiagnosticos();
//     } catch (Exception $e) {
//         $respuesta = array(
//             'estado' => 'error'
//         );
//     }

//     die(json_encode($respuesta));
// }

if ($accion == 'insertarCovid') {
    if ($idPaciente == false || $estadoCovid === false || $internacion === false || $descripcion == false) {
        $respuesta = array(
            'estado' => 'errorInputs'
        );

        die(json_encode($respuesta));
    } else {
        $covid = new covidModelo();
        $covid->setIdPaciente($idPaciente);
        $covid->setEstadoCovid($estadoCovid);
        $covid->setInternacion($internacion);
        $covid->setDescripcion($descripcion);

        try {
            $respuesta = $covid->insertarCovid();
        } catch (Exception $e) {
            $respuesta = array(
                'estado' => 'error'
            );
        }

        die(json_encode($respuesta));
    }
}

// if ($accion == 'eliminarDiagnostico') {
//     if ($id == false) {
//         $respuesta = array(
//             'estado' => 'errorInputs'
//         );

//         die(json_encode($respuesta));
//     } else {
//         $diagnostico = new DiagnosticosModelo();
//         $diagnostico->setId($id);

//         try {
//             $respuesta = $diagnostico->eliminarDiagnostico();
//         } catch (Exception $e) {
//             $respuesta = array(
//                 'estado' => 'error'
//             );
//         }

//         die(json_encode($respuesta));
//     }
// }