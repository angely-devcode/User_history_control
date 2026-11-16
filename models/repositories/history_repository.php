<?php
class HistoryRepository implements HistoryRepositoryInterface {
    private $historiasDb;

    public function __construct(HistoryDbInterface $historiasDb)
    {
        $this->historiasDb=$historiasDb;
    }

    public function listHistory(){
        $filas = $this->historiasDb->getAll();
        $listaHistorias = [];

        foreach($filas as $fila){
            $listaHistorias[]= HistoryModelMapper::mapToEntity($fila);
        }
        return $listaHistorias;
    }

    public function listHistoryBySprint($sprintId){
        $filas = $this->historiasDb->getBySprint($sprintId);
        $listaHistorias = [];

        foreach($filas as $fila){
            $listaHistorias[]= HistoryModelMapper::mapToEntity($fila);
        }
        return $listaHistorias;
    }

    public function searchHistoryById($id){
        $fila = $this->historiasDb->getById($id);
        if (!$fila) {
            return null;
        }
        return HistoryModelMapper::mapToEntity($fila);

    }

    public function saveHistory($historia){
        return $this->historiasDb->insert($historia);
    }

    public function editHistory($historia){
        return $this->historiasDb->update($historia);
    }

    public function deleteHistory($id){
        return $this->historiasDb->delete($id);
    }

}