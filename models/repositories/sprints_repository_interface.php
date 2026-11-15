<?php
interface SprintsRepositoryInterface {
    public function listSprints();
    public function searchSprintPorId($id);
    public function saveSprint($sprint);
}