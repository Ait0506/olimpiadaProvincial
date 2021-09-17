<?php

class BD
{
    public static function conectar()
    {
        $bd = new mysqli('localhost', 'root', 'root', 'bd_epet');
        $bd->set_charset('utf8');
        return $bd;
    }
}
