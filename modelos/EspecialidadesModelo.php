<?php
class EspecialidadesModelo extends PadreModelo
{
    private $especialidad;

    function __construct()
    {
        parent::__construct();
    }

	public function getEspecialidad(){
		return $this->especialidad;
	}

	public function setEspecialidad($especialidad){
		$this->especialidad = $this->bd->real_escape_string($especialidad);
	}

    public function obtenerEspecialidades() {
        try {
            $sql = "SELECT * FROM `especialidades`";
            $res = $this->bd->query($sql);
            $especialidades = array();

            if ($res) {
                while ($esp = $res->fetch_assoc()) {
                    array_push($especialidades, $esp);
                }
                $estado = array(
                    'estado' => 'satisfactorio',
                    'datos' => $especialidades
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

    public function insertarEspecialidad() {
        $especialidad = $this->getEspecialidad();
        try {
            $stmt = $this->bd->prepare("INSERT INTO `especialidades` (especialidad) VALUES (?)");
            if($stmt) {
                $stmt->bind_param('s', $especialidad);
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

    public function eliminarEspecialidad()
    {
        $estado = '';
        $id = $this->getId();

        try {
            $sql = "DELETE FROM `especialidades` where id = $id";
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
