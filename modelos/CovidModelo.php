<?php
class CovidModelo extends PadreModelo
{
    private $idPaciente;
    private $estadoCovid;
    private $internacion;
    private $descripcion;

    function __construct()
    {
        parent::__construct();
    }

    public function getIdPaciente()
    {
        return $this->idPaciente;
    }

    public function setIdPaciente($idPaciente)
    {
        $this->idPaciente = $this->bd->real_escape_string($idPaciente);
    }

    public function getEstadoCovid()
    {
        return $this->estadoCovid;
    }

    public function setEstadoCovid($estadoCovid)
    {
        $this->estadoCovid = $this->bd->real_escape_string($estadoCovid);
    }

    public function getInternacion()
    {
        return $this->internacion;
    }

    public function setInternacion($internacion)
    {
        $this->internacion = $this->bd->real_escape_string($internacion);
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $this->bd->real_escape_string($descripcion);
    }

    // public function obtenerDiagnosticos() {
    //     try {
    //         $sql = "SELECT diagnosticos.id, diagnosticos.descripcion as 'descripcion', profesionales.nombre as 'nombreProfesional', profesionales.apellido as 'apellidoProfesional', profesionales.id as 'idProfesional', especialidades.especialidad as 'especialidad', pacientes.id as 'idPaciente', pacientes.nombre as 'nombrePaciente', pacientes.apellido as 'apellidoPaciente', pacientes.genero as 'generoPaciente', pacientes.dni as 'dniPaciente' FROM `diagnosticos` INNER JOIN `profesionales` ON diagnosticos.idProfesional = profesionales.id INNER JOIN `pacientes` ON diagnosticos.idPaciente = pacientes.id INNER JOIN `especialidades` ON profesionales.idEspecialidad = especialidades.id";
    //         $res = $this->bd->query($sql);
    //         $diagnosticos = array();

    //         if ($res) {
    //             while ($diag = $res->fetch_assoc()) {
    //                 array_push($diagnosticos, $diag);
    //             }
    //             $estado = array(
    //                 'estado' => 'satisfactorio',
    //                 'datos' => $diagnosticos
    //             );
    //         } else {
    //             $estado = array(
    //                 'estado' => 'error'
    //             );
    //         }
    //     } catch (Exception $e) {
    //         $estado = array(
    //             'estado' => 'error'
    //         );
    //     }
    //     return $estado;
    // }

    public function insertarCovid()
    {
        $estado = '';
        $idPaciente = $this->getIdPaciente();
        $estadoCovid = $this->getEstadoCovid();
        $internacion = $this->getInternacion();
        $descripcion = $this->getDescripcion();

        try {
            $stmt = $this->bd->prepare("INSERT INTO `seguimientoCovid` (`idPaciente`, `estadoCovid`, `internacion`, `descripcion`) VALUES (?, ?, ?, ?)");
            if($stmt) {
                $stmt->bind_param('iiis', $idPaciente, $estadoCovid, $internacion, $descripcion);
                $stmt->execute();
            } else {
                $estado = array(
                    'estado' => 'error'
                );
                return $estado;
            }

            if ($stmt->affected_rows > 0) {
                $estado = array(
                    'estado' => 'satisfactorio',
                    'datos' => ['id' => $stmt->insert_id]
                );
            } else {
                $estado = array(
                    'estado' => 'error'
                );
            }
        } catch (Exception $e) {
            $estado = array(
                'estado' => 'error'
            );
        }

        $stmt->close();
        return $estado;
    }

    public function eliminarCovid()
    {
        $estado = '';
        $id = $this->getId();

        try {
            $sql = "DELETE FROM `seguimientocovid` where id = $id";
            $res = $this->bd->query($sql);

            if ($res) {
                $estado = array(
                    'estado' => 'satisfactorio'
                );
            } else {
                $estado = array(
                    'estado' => 'error'
                );
            }
        } catch (Exception $e) {
            $estado = array(
                'estado' => 'error'
            );
        }

        return $estado;
    }
}
