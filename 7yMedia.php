<?php
include "clases/Carta.php";


Class Main
{
    private $cartas;
    private $manos;

    private function inicializar()
    {
        $this->cartas = array();
        $this->manos = array();

        for ($palo = 0; $palo < 4; $palo++) {
            for ($num = 1; $num <= 10; $num++) {
                $carta = Carta::crearCarta($num, $palo);
                array_push($this->cartas, $carta);
            }
        }
    }

    /**
     * @param bool $maquina
     * @param Carta $carta
     * @param int $contador
     */

    private function getTextoTurno($maquina, $carta, $contador)
    {
        $haber = $maquina ? "Ha" : "Has";
        $llevar = $maquina ? "Lleva" : "Llevas";
        $puntos = ($carta->getValor() === 1) ? "punto" : "puntos";
        $opciones = ($maquina || $contador >= 7.5) ? "\n" : " Plantarse (p) o Continuar (c).\n";
        echo $haber . " sacado el " . $carta->getNombre() . " de " . $carta->getPalo() . ". " . $llevar .
            " " . $contador . " " . $puntos . "." . $opciones;
    }

    /**
     * @return Carta $carta
     */
    private function getCarta()
    {
        $posicion = rand(0, sizeof($this->cartas));
        $carta = array_splice($this->cartas, $posicion, 1);
        $carta = ($carta !== null) ? array_pop($carta) : null;
        return $carta;
    }


    /**
     * @param int $jugador
     * @return float
     */

    private function contarPuntuacion($jugador)
    {
        $cont = 0.0;
        $mano = null;
        try {
            $mano = $this->manos[$jugador];
        } catch (NullPointerException $e) {
            return $cont;
        }

        foreach ($mano as $carta) {
            $cont += $carta->getValor();
        }

        return $cont;
    }

    private function bienvenida()
    {
        echo "Bienvenido a las 7 y media\n\n\n";
        echo "Pulse cualquier tecla para comenzar\n";
        fgetc(STDIN);
    }

    /**
     * @param bool $maquina
     */

    private function nuevoTurno($maquina)
    {
        $input = 'c';
        $cont = 0.0;
        $mano = array();
        $jugador = $maquina ? "Máquina" : "Humano";
        while ($input !== 'p' && $cont < 7.5) {
            if ($input === 'c') {

                echo "\nJugador $jugador pide carta.\n";

                $carta = $this->getCarta();

                if ($carta === null)
                    continue;

                $mano[] = $carta;

                $cont += $carta->getValor();
                $this->getTextoTurno($maquina, $carta, $cont);

                if ($cont < 7.5 && !$maquina)
                    $input = fgetc(STDIN);

            } else {
                echo "Opción incorrecta. Plantarse (p) o Continuar (c)\n";
                $input = fgetc(STDIN);
            }

            if ($maquina && $this->contarPuntuacion(sizeof($this->manos) - 1) < $cont) {
                $input = 'p';
            }

            if ($input === 'p' && !$maquina) {
                echo "\nJugador $jugador se planta.\n";
            }
        }
        $this->manos[] = $mano;
    }

    private function proclamarGanador()
    {
        $humano = $this->contarPuntuacion(0);
        $maquina = $this->contarPuntuacion(1);
        $ganador = "Máquina";

        if ($humano <= 7.5) {
            if ($maquina > 7.5) {
                $ganador = "Humano";
            } elseif ($maquina == 7.5) {
                $ganador = "Máquina";
            } else {
                if ($humano > $maquina) {
                    $ganador = "Humano";
                } else {
                    $ganador = "Máquina";
                }
            }
        } else {
            $ganador = "Máquina";
        }

        echo "Jugador $ganador gana la partida. Repetir (r) o Abandonar (a).\n";
    }

    public function juego()
    {
        system("stty -icanon");
        $this->bienvenida();
        do {
            $this->inicializar();
            $this->nuevoTurno(false);
            $this->nuevoTurno(true);
            $this->proclamarGanador();
            do {
                $input = fgetc(STDIN);
                if ($input != 'a' && $input != 'r')
                    echo 'Opción incorrecta. Repetir (r) o Abandonar (a).\n';
            }while($input != 'a' && $input != 'r');
        } while ($input != 'a');
    }
}

$main = new Main();
$main->juego();


