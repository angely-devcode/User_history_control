<?php
interface HistoryRepositoryInterface {
    public function listHistory();
    public function listHistoryBySprint($sprintId);
    public function searchHistoryById($id);
    public function saveHistory($historia);
    public function editHistory($historia);
    public function deleteHistory($id);
}