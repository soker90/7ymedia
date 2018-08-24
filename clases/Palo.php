<?php


abstract class Palo
{
    private static $palos = array("Bastos","Copas","Espadas","Oros");

    /**
     * @return String
     */
    public static function getPalos($index)
    {
        return self::$palos[$index];
    }
}