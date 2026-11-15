<?php
interface HistoryDbInterface{
    public function getAll();
    public function getBySprint($sprintId);
    public function getById($id);
    public function insert($historia);
    public function update($historia);
    public function delete($id);
}