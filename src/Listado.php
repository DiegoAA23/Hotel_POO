<?php

namespace Uch\Hotel;

class Listado
{
    public static function obtenerListado()
    {
        if (isset($_SESSION['listado'])) {
            return self::deserializarlistado($_SESSION['listado']);
        } else {
            return [];
        }
    }

    public static function guardarListado($reservacion)
    {
        $listado = self::obtenerListado();
        $listado[] = $reservacion;
        $_SESSION['listado'] = self::serializarListado($listado);
    }

    private static function deserializarListado($listado)
    {
        $listadoDeserializadas = [];
        foreach ($listado as $reservacion) {
            $reservacionDeserializada = new Reservacion();
            $reservacionDeserializada->fromJson($reservacion);
            $listadoDeserializadas[] = $reservacionDeserializada;
        }
        return $listadoDeserializadas;
    }

    private static function serializarlistado($listado)
    {
        $listadoSerializadas = [];
        foreach ($listado as $reservacion) {
            $listadoSerializadas[] = $reservacion->toJson();
        }
        return $listadoSerializadas;
    }
    public static function limpiarListado()
    {
        unset($_SESSION['listado']);
    }
}
