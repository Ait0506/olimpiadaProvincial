<?php
class PacientesModelo extends PadreModelo
{
    private $nombre;
    private $apellido;
    private $genero;
    private $fechaNacimiento;
    private $dni;

    function __construct()
    {
        parent::__construct();
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->bd->real_escape_string($nombre);
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $this->bd->real_escape_string($apellido);
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $this->bd->real_escape_string($fechaNacimiento);
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $this->bd->real_escape_string($dni);
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero)
    {
        $this->genero = $this->bd->real_escape_string($genero);
    }

    public function obtenerPacientes() {
        try {
            $sql = "SELECT *  FROM `pacientes`";
            $res = $this->bd->query($sql);
            $pacientes = array();

            if ($res) {
                while ($pac = $res->fetch_assoc()) {
                    array_push($pacientes, $pac);
                }
                $estado = array(
                    'estado' => 'satisfactorio',
                    'datos' => $pacientes
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

    public function insertarPaciente()
    {
        $estado = '';
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $genero = $this->getGenero();
        $dni = $this->getDni();
        $fechaNacimiento = $this->getFechaNacimiento();

        try {
            $stmt = $this->bd->prepare("INSERT INTO `pacientes` (`nombre`, `apellido`, `dni`, `fechaNacimiento`, `genero`) VALUES (?, ?, ?, ?, ?)");
            if($stmt) {
                $stmt->bind_param('sssss', $nombre, $apellido, $dni, $fechaNacimiento, $genero);
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

    public function eliminarPaciente()
    {
        $estado = '';
        $id = $this->getId();

        try {
            $sql = "DELETE FROM `pacientes` where id = $id";
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
