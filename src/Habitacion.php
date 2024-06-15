<?php

namespace Uch\Hotel;

class Habitacion
{
    private $codigo;
    private $descripcion;

    public function __construct(
        $codigo = 0,
        $descripcion = ""
    ) {
        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function toAssocArray()
    {
        return [
            "codigo" => $this->codigo,
            "descripcion" => $this->descripcion
        ];
    }

    public function toJson()
    {
        return json_encode($this->toAssocArray());
    }

    public function fromAssocArray($array)
    {
        $this->codigo = $array["codigo"];
        $this->descripcion = $array["descripcion"];
    }

    public function fromJson($json)
    {
        $this->fromAssocArray(json_decode($json, true));
    }
}
