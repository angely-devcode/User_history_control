<?php
interface SprintsControllerInterface {
    public function getAllSprints();
    public function getSprintById($id);
    public function createSprint($datos);
}