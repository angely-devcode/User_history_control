<?php
class HistoryModelMapper{
    public static function mapToEntity($fila){
        $historia = new History();
        $historia->id = $fila['id'];
        $historia->titulo = $fila['titulo'];
        $historia->descripcion = $fila['descripcion'];
        $historia->responsable = $fila['responsable'];
        $historia->estado = $fila['estado'];
        $historia->puntos = $fila['puntos'];
        $historia->fecha_creacion = $fila['fecha_creacion'];
        $historia->fecha_finalizacion = $fila['fecha_finalizacion'];
        $historia->sprint_id = $fila['sprint_id'];
        return $historia;
    }
}