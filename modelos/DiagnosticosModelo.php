<?php
class DiagnosticosModelo extends PadreModelo
{
    private $idPaciente;
    private $idProfesional;
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

    public function getIdProfesional()
    {
        return $this->idProfesional;
    }

    public function setIdProfesional($idProfesional)
    {
        $this->idProfesional = $this->bd->real_escape_string($idProfesional);
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $this->bd->real_escape_string($descripcion);
    }

    public function obtenerDiagnosticos() {
        try {
            $sql = "SELECT diagnosticos.id, diagnosticos.descripcion as 'descripcion', profesionales.nombre as 'nombreProfesional', profesionales.apellido as 'apellidoProfesional', profesionales.id as 'idProfesional', especialidades.especialidad as 'especialidad', pacientes.id as 'idPaciente', pacientes.nombre as 'nombrePaciente', pacientes.apellido as 'apellidoPaciente', pacientes.genero as 'generoPaciente', pacientes.dni as 'dniPaciente' FROM `diagnosticos` INNER JOIN `profesionales` ON diagnosticos.idProfesional = profesionales.id INNER JOIN `pacientes` ON diagnosticos.idPaciente = pacientes.id INNER JOIN `especialidades` ON profesionales.idEspecialidad = especialidades.id";
            $res = $this->bd->query($sql);
            $diagnosticos = array();

            if ($res) {
                while ($diag = $res->fetch_assoc()) {
                    array_push($diagnosticos, $diag);
                }
                $estado = array(
                    'estado' => 'satisfactorio',
                    'datos' => $diagnosticos
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

    public function insertarDiagnostico()
    {
        $estado = '';
        $idPaciente = $this->getIdPaciente();
        $idProfesional = $this->getIdProfesional();
        $descripcion = $this->getDescripcion();

        try {
            $stmt = $this->bd->prepare("INSERT INTO `diagnosticos` (`idPaciente`, `idProfesional`, `descripcion`) VALUES (?, ?, ?)");
            if($stmt) {
                $stmt->bind_param('iis', $idPaciente, $idProfesional, $descripcion);
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

    public function eliminarDiagnostico()
    {
        $estado = '';
        $id = $this->getId();

        try {
            $sql = "DELETE FROM `diagnosticos` where id = $id";
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
