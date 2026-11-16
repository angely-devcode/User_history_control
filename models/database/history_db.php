<?php
class HistoryDb implements HistoryDbInterface
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }


    public function getAll()
    {
        $sql = "SELECT * FROM  historias ORDER BY id DESC";
        $resultado = $this->conexion->query($sql);
        $filas = [];

        while ($fila = $resultado->fetch_assoc()) {
            $filas[] = $fila;
        }
        return $filas;
    }

    public function getBySprint($sprintId)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM historias WHERE sprint_id = ? ORDER BY id DESC");
        $stmt->bind_param("i", $sprintId);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $filas = [];

        while ($fila = $resultado->fetch_assoc()) {
            $filas[] = $fila;
        }
        return $filas;
    }

    public function getById($id)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM historias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function insert($historia)
    {
        $stmt = $this->conexion->prepare("INSERT INTO historias (titulo, descripcion, responsable, estado, puntos, fecha_creacion, fecha_finalizacion, sprint_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssssissi",
            $historia->titulo,
            $historia->descripcion,
            $historia->responsable,
            $historia->estado,
            $historia->puntos,
            $historia->fecha_creacion,
            $historia->fecha_finalizacion,
            $historia->sprint_id
        );
        return $stmt->execute();
    }

    public function update($historia)
    {
        $stmt = $this->conexion->prepare(
            "UPDATE historias
             SET titulo = ?, descripcion = ?, responsable = ?, estado = ?, puntos = ?, fecha_creacion = ?, fecha_finalizacion = ?, sprint_id = ?
             WHERE id = ?"
        );
        $stmt->bind_param(
            "ssssissii",
            $historia->titulo,
            $historia->descripcion,
            $historia->responsable,
            $historia->estado,
            $historia->puntos,
            $historia->fecha_creacion,
            $historia->fecha_finalizacion,
            $historia->sprint_id,
            $historia->id
        );
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conexion->prepare("DELETE FROM historias WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
