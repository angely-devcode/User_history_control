<?php

interface SprintsDbInterface {
    public function getAll();
    public function getById($id);
    public function insert($sprint);
}