<?php
class ProfesionalesModelo extends PadreModelo
{
    private $nombre;
    private $apellido;
    private $idEspecialidad;
    private $fechaNacimiento;
    private $dni;
    private $password;

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

    public function getIdEspecialidad()
    {
        return $this->idEspecialidad;
    }

    public function setIdEspecialidad($idEspecialidad)
    {
        $this->idEspecialidad = $this->bd->real_escape_string($idEspecialidad);
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $this->bd->real_escape_string($dni);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $this->bd->real_escape_string($password);
    }

    public function iniciarSesion(){
        $dni = $this->getDni();
        $password = $this->getPassword();

        try {
            $sql = "SELECT *, profesionales.id as 'id' FROM `profesionales` INNER JOIN `especialidades` ON profesionales.idEspecialidad = especialidades.id WHERE dni = '$dni'";
            $res = $this->bd->query($sql);

            if ($res) {
                if ($prof = $res->fetch_assoc()) {
                    if (password_verify($password, $prof['password'])) {
                        $estado = array(
                            'estado' => 'satisfactorio',
                            'datos' => $prof,
                        );
                    } else {
                        $estado = array(
                            'estado' => 'errorPassword'
                        );
                    }
                } else {
                    $estado = array(
                        'estado' => 'errorUsuario'
                    );
                }
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

    public function obtenerProfesionales() {
        try {
            $sql = "SELECT *, profesionales.id as 'id' FROM `profesionales` INNER JOIN `especialidades` ON profesionales.idEspecialidad = especialidades.id";
            $res = $this->bd->query($sql);
            $profesionales = array();

            if ($res) {
                while ($prof = $res->fetch_assoc()) {
                    array_push($profesionales, $prof);
                }
                $estado = array(
                    'estado' => 'satisfactorio',
                    'datos' => $profesionales
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

    public function insertarProfesional()
    {
        $estado = '';
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $idEspecialidad = $this->getidEspecialidad();
        $dni = $this->getDni();
        $fechaNacimiento = $this->getFechaNacimiento();
        $password = $this->getPassword();

        try {
            $stmt = $this->bd->prepare("INSERT INTO `profesionales` (`nombre`, `apellido`, `idEspecialidad`, `dni`, `fechaNacimiento`, `password`) VALUES (?, ?, ?, ?, ?, ?)");
            if($stmt) {
                $stmt->bind_param('ssisss', $nombre, $apellido, $idEspecialidad, $dni, $fechaNacimiento, $password);
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

    public function eliminarProfesional()
    {
        $estado = '';
        $id = $this->getId();

        try {
            $sql = "DELETE FROM `profesionales` where id = $id";
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
