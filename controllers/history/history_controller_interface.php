<?php
interface HistoryControllerInterface {
    public function getAllHistory();
    public function getHistoryById($id);
    public function createHistory($datos);
    public function updateHistory($datos);
    public function deleteHistory($id);
    public function getHistoryGroupedBySprint();
    public function generateReport();
}