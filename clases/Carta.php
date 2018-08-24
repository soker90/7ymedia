<?php
include "Palo.php";

class Carta
{

    private $nombre;
    private $palo;
    private $valor;

    /**
     * Carta constructor.
     * @param $nombre
     * @param $palo
     * @param $valor
     */

    public function __construct($nombre, $palo, $valor)
    {
        $this->nombre = $nombre;
        $this->palo = $palo;
        $this->valor = $valor;
    }

    /**
     * @return String
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param String $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return String
     */
    public function getPalo()
    {
        return $this->palo;
    }

    /**
     * @param String $palo
     */
    public function setPalo($palo)
    {
        $this->palo = $palo;
    }

    /**
     * @return int
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @param int $num
     * @param int $palo
     * @return Carta
     */
    public static function crearCarta($num, $palo)
    {
        $sPalo = Palo::getPalos($palo);
        switch ($num) {
            case 10:
                $nombre = "Rey";
                $valor = 0.5;
                break;
            case 9:
                $nombre = "Caballo";
                $valor = 0.5;
                break;
            case 8:
                $nombre = "Sota";
                $valor = 0.5;
                break;
            case 1:
                $nombre = "As";
                $valor = $num;
                break;
            default:
                $nombre = $num;
                $valor = $num;
        }

        return new Carta($nombre, $sPalo, $valor);
    }

}