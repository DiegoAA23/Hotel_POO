<?php

namespace Uch\Hotel;

class HabitacionCuadruple extends HabitacionSimple
{
    public function __construct(
        $codigo = 0,
        $descripcion = "",
        $tieneVista = false
    ) {
        parent::__construct($codigo, $descripcion, $tieneVista);
        $this->tipo = "Cuadruple";
        $this->price = 3000;
    }
}
