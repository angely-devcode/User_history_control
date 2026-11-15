<?php
class SprintsModelMapper{
    public static function mapToEntity($fila){
        $sprint = new Sprint ();
        $sprint->id = $fila['id'];
        $sprint->nombre = $fila['nombre'];
        $sprint->fecha_inicio = $fila['fecha_inicio'];
        $sprint->fecha_fin = $fila['fecha_fin'];
        return $sprint;
    }
}