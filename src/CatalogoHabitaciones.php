<?php

namespace Uch\Hotel;

class CatalogoHabitaciones
{
    private static $habitaciones = [];
    public static function getHabitaciones()
    {
        if (empty(self::$habitaciones)) {
            self::init();
        }
        return self::$habitaciones;
    }

    public static function getHabitacionesAssoc()
    {
        $habitacionesAssoc = [];
        foreach (self::getHabitaciones() as $habitacion) {
            $habitacionesAssoc[] = $habitacion->toAssocArray();
        }
        return $habitacionesAssoc;
    }

    public static function getHabitacionPorCodigo($codigo)
    {
        foreach (self::getHabitaciones() as $habitacion) {
            if ($habitacion->getCodigo() == $codigo) {
                return $habitacion;
            }
        }
        return null;
    }

    private static function init()
    {
        self::$habitaciones = [
            new HabitacionSimple(1, "Habitación 1", true),
            new HabitacionSimple(2, "Habitación 2", false),
            new HabitacionDoble(3, "Habitación 3", true),
            new HabitacionDoble(4, "Habitación 4", false),
            new HabitacionCuadruple(5, "Habitación 5", true),
            new HabitacionCuadruple(6, "Habitación 6", false)
        ];
    }

    private function __construct()
    {
    }
}
