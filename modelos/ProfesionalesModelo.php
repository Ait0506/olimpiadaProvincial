<?php
class ProfesionalesModelo extends PadreModelo
{
    private $dni;
    private $password;

    function __construct()
    {
        parent::__construct();
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
            $sql = "SELECT * FROM `profesionales` INNER JOIN `especialidades` ON profesionales.idEspecialidad = especialidades.id WHERE dni = '$dni'";
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
}
