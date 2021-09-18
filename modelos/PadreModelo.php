<?php

class PadreModelo
{
    protected $bd;
    protected $id;
    protected $creado;
    protected $editado;

    function __construct()
    {
        $this->bd = BD::conectar();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $this->bd->real_escape_string($id);
    }

    public function getCreado()
    {
        return $this->creado;
    }

    public function setCreado($creado)
    {
        $this->creado = $this->bd->real_escape_string($creado);
    }
}