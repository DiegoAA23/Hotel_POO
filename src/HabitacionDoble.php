<?php

namespace Uch\Hotel;

class HabitacionDoble extends HabitacionSimple
{
    public function __construct(
        $codigo = 0,
        $descripcion = "",
        $tieneVista = false
    ) {
        parent::__construct($codigo, $descripcion, $tieneVista);
        $this->tipo = "Doble";
        $this->price = 1500;
    }
}
