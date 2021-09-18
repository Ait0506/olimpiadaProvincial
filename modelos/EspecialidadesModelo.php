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
}
