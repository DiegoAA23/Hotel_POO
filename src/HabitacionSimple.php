<?php

namespace Uch\Hotel;

class HabitacionSimple extends Habitacion implements IHabitacion
{
    protected $tieneVista = true;
    protected $tipo = "Simple";
    protected $price = 1000;

    public function __construct(
        $codigo = 0,
        $descripcion = "",
        $tieneVista = false
    ) {
        parent::__construct($codigo, $descripcion);
        $this->tieneVista = $tieneVista;
    }

    public function getTieneVista()
    {
        return $this->tieneVista;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function getPrice()
    {
        if ($this->tieneVista) {
            return $this->price * 1.2;
        }
        return $this->price;
    }

    public function toAssocArray()
    {
        return array_merge(
            parent::toAssocArray(),
            [
                "tieneVista" => $this->tieneVista,
                "tipo" => $this->tipo,
                "price" => $this->getPrice()
            ]
        );
    }
    public function fromJson($json)
    {
        $tmpObject = json_decode($json, true);
        $this->fromAssocArray($tmpObject);
    }
    public function fromAssocArray($array)
    {
        parent::fromAssocArray($array);
        $this->tieneVista = $array["tieneVista"];
        $this->tipo = $array["tipo"];
        $this->price = $array["price"];
    }
}
