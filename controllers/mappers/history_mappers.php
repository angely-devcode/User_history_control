<?php
class HistoryControllerMapper{
    public static function mapRequestToEntity($datos){
        $historia = new History;
        $historia->id = isset($datos['id'])? (int)$datos['id'] : null;
        $historia->titulo = trim($datos['titulo']);
        $historia->descripcion = trim($datos['descripcion']);
        $historia->responsable = trim($datos['responsable']);
        $historia->estado = !empty($datos['estado']) ? $datos['estado'] : 'nueva';
        $historia->puntos = (int)$datos['puntos'];
        $historia->fecha_creacion = !empty($datos['fecha_creacion']) ? $datos['fecha_creacion'] : date('Y-m-d');
        $historia->sprint_id = (int)$datos['sprint_id'];

        if ($historia->estado === 'finalizada') {
            $historia->fecha_finalizacion = !empty($datos['fecha_finalizacion']) ? $datos['fecha_finalizacion'] : date('Y-m-d');
        } else {
            $historia->fecha_finalizacion = null;
        }

        return $historia;
    }
}