<?php

class sprints_db implements sprints_db_interface{

private $conexion;

public function __construct($conexion){
    $this->conexion = $conexion;
}

	public function obtenerTodos()
    {
        $sql = "SELECT * FROM sprints ORDER BY fecha_inicio ASC";
        $resultado = $this->conexion->query($sql);
        $filas = [];

        while($fila = $resultado->fetch_assoc()){
            $filas[] = $fila;
        }
        return $filas;
    }

    public function obtenerPorId($id)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM sprints WHERE id = ?");
        $consulta->bind_param("i", $id);
        $consulta->execute();
        $resultado = $consulta->get_result();
        return $resultado->fetch_assoc();
    }

    public function insertar($sprint)
    {
        $consulta = $this->conexion->prepare("INSERT INTO sprints (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?,)");
        $consulta->bind_param("sss", $sprint->nombre,
        $sprint->fecha_inicio,
        $sprint->fecha_fin);
        return $consulta->execute();

    }

}