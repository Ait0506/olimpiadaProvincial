<?php

class BD
{
    public static function conectar()
    {
        $bd = new mysqli('localhost', 'root', 'root', 'olimpiadas_inf');
        $bd->set_charset('utf8');
        return $bd;
    }
}
