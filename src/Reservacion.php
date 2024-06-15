<?php

namespace Uch\Hotel;

use DateTime;
use PDO;

class Reservacion
{
    private $codigo;
    private $nombreCliente;
    private $telefono;
    private $correo;
    private $fechaEntrada;
    private $fechaSalida;
    private $habitaciones;
    private $numeroPersonas;
    private $incluyeDesayuno;

    public function __construct(
        $codigo = "0",
        $nombreCliente = "",
        $telefono = "",
        $correo = "",
        $fechaEntrada = new DateTime(),
        $fechaSalida = new DateTime(),
        $numeroPersonas = 1,
        $incluyeDesayuno = false
    ) {
        $this->codigo = $codigo;
        $this->nombreCliente = $nombreCliente;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->fechaEntrada = $fechaEntrada->setTime(0, 0, 0);
        $this->fechaSalida = $fechaSalida->setTime(23, 59, 59);
        $this->habitaciones = [];
        $this->numeroPersonas = $numeroPersonas;
        $this->incluyeDesayuno = $incluyeDesayuno;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    public function getNombreCliente()
    {
        return $this->nombreCliente;
    }
    public function setNombreCliente($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;
    }
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;
    }
    public function getNumeroPersonas()
    {
        return $this->numeroPersonas;
    }
    public function setNumeroPersonas($numeroPersonas)
    {
        $this->numeroPersonas = $numeroPersonas;
    }
    public function getIncluyeDesayuno()
    {
        return $this->incluyeDesayuno;
    }
    public function setIncluyeDesayuno($incluyeDesayuno)
    {
        $this->incluyeDesayuno = $incluyeDesayuno;
    }
    public function clearHabitaciones()
    {
        $this->habitaciones = [];
    }
    public function addHabitacion($habitacion)
    {
        if ($habitacion instanceof IHabitacion) {
            $this->habitaciones[] = $habitacion;
        } else {
            throw new \Exception("No es una habitación válida");
        }
    }

    public function getHabitaciones()
    {
        return $this->habitaciones;
    }

    public function getDiasReserva()
    {
        $diferencia = $this->fechaEntrada->diff($this->fechaSalida);
        return $diferencia->days;
    }

    public function getPrecioTotal()
    {
        $precioTotal = 0;
        $diasReserva = $this->getDiasReserva();
        foreach ($this->habitaciones as $habitacion) {
            $precioTotal += $habitacion->getPrice() * $diasReserva;
        }
        $precioTotal *= $this->numeroPersonas;
        if ($this->incluyeDesayuno) {
            $precioTotal += 180 * $this->numeroPersonas * $diasReserva;
        }
        return $precioTotal;
    }

    public function toAssocArray()
    {
        $habitaciones = [];
        foreach ($this->habitaciones as $habitacion) {
            $habitaciones[] = $habitacion->toAssocArray();
        }
        return [
            "codigo" => $this->codigo,
            "nombreCliente" => $this->nombreCliente,
            "telefono" => $this->telefono,
            "correo" => $this->correo,
            "fechaEntrada" => $this->fechaEntrada->format("Y-m-d"),
            "fechaSalida" => $this->fechaSalida->format("Y-m-d"),
            "numeroPersonas" => $this->numeroPersonas,
            "incluyeDesayuno" => $this->incluyeDesayuno,
            "habitaciones" => $habitaciones,
            "precioTotal" => $this->getPrecioTotal()
        ];
    }

    public function fromJson($reservaJsonString)
    {
        $this->fromAssocArray(json_decode($reservaJsonString, true));
    }

    public function fromAssocArray($data)
    {
        $this->codigo = $data["codigo"];
        $this->nombreCliente = $data["nombreCliente"];
        $this->telefono = $data["telefono"];
        $this->correo = $data["correo"];
        $this->fechaEntrada = new DateTime($data["fechaEntrada"]);
        $this->fechaSalida = new DateTime($data["fechaSalida"]);
        $this->numeroPersonas = $data["numeroPersonas"];
        $this->incluyeDesayuno = $data["incluyeDesayuno"];
        $this->habitaciones = [];
        foreach ($data["habitaciones"] as $habitacion) {
            $tmpHabitacion = FabricaHabitacion::crearHabitacionFromAssoc($habitacion);
            $this->habitaciones[] = $tmpHabitacion;
        }
    }

    public function toJson()
    {
        return json_encode($this->toAssocArray());
    }
}
