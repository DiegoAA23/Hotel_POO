<?php

namespace Uch\Hotel;

interface IHabitacion
{
    public function getCodigo();
    public function setCodigo($codigo);
    public function getDescripcion();
    public function setDescripcion($descripcion);
    public function getTieneVista();
    public function getTipo();
    public function getPrice();
    public function toAssocArray();
    public function toJson();
    public function fromAssocArray($array);
    public function fromJson($json);
}
