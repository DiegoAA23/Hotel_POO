<?php

namespace Uch\Hotel;

class FabricaHabitacion
{
    public static function crearHabitacion($tipo, $codigo, $descripcion, $tieneVista)
    {
        switch ($tipo) {
            case "Simple":
                return new HabitacionSimple($codigo, $descripcion, $tieneVista);
            case "Doble":
                return new HabitacionDoble($codigo, $descripcion, $tieneVista);
            case "Cuadruple":
                return new HabitacionCuadruple($codigo, $descripcion, $tieneVista);
            default:
                return new HabitacionSimple($codigo, $descripcion, $tieneVista);
        }
    }

    public static function crearHabitacionFromAssoc($assocHabitacion)
    {
        $tipo = $assocHabitacion["tipo"];
        $codigo = $assocHabitacion["codigo"];
        $descripcion = $assocHabitacion["descripcion"];
        $tieneVista = $assocHabitacion["tieneVista"];
        return self::crearHabitacion($tipo, $codigo, $descripcion, $tieneVista);
    }
}
