<?php
class history_mappers{
    public static function mapToEntity($fila){
        $historia = new History();
        $historia->id = $fila['id'];
        $historia->titulo = $fila['titulo'];
        $historia->descripcion = $fila['descripcion'];
        $historia->responsable = $fila['repsonsable'];
        $historia->estado = $fila['estado'];
        $historia->puntos = $fila['puntos'];
        $historia->fecha_creación = $fila['fecha_creacion'];
        $historia->fecha_finalizacion = $fila['fehca_finalizacion'];
        $historia->sprint_id = $fila['sprint_id'];
        return $historia;
    }
}