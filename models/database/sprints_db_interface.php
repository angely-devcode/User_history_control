<?php

interface sprints_db_interface {
    public function obtenerTodos();
    public function obtenerPorId($id);
    public function insertar($sprint);
}