<?php

namespace Uch\Hotel;

class Reservaciones
{
    public static function obtenerReservaciones()
    {
        if (isset($_SESSION['reservaciones'])) {
            return self::deserializarReservaciones($_SESSION['reservaciones']);
        } else {
            return [];
        }
    }

    public static function guardarReservacion($reservacion)
    {
        $reservaciones = self::obtenerReservaciones();
        $reservaciones[] = $reservacion;
        $_SESSION['reservaciones'] = self::serializarReservaciones($reservaciones);
    }

    private static function deserializarReservaciones($reservaciones)
    {
        $reservacionesDeserializadas = [];
        foreach ($reservaciones as $reservacion) {
            $reservacionDeserializada = new Reservacion();
            $reservacionDeserializada->fromJson($reservacion);
            $reservacionesDeserializadas[] = $reservacionDeserializada;
        }
        return $reservacionesDeserializadas;
    }

    private static function serializarReservaciones($reservaciones)
    {
        $reservacionesSerializadas = [];
        foreach ($reservaciones as $reservacion) {
            $reservacionesSerializadas[] = $reservacion->toJson();
        }
        return $reservacionesSerializadas;
    }
}
