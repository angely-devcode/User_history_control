<?php
class SprintsControllerMapper
{
    public static function mapRequestToEntity($datos)
    {
        $sprint = new Sprint();
        $sprint->id = isset($datos['id']) ? (int)$datos['id'] : null;
        $sprint->nombre = trim($datos['nombre']);
        $sprint->fecha_inicio = $datos['fecha_inicio'];
        $sprint->fecha_fin = $datos['fecha_fin'];
        return $sprint;
    }
}
