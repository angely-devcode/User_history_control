<?php
class SprintsRepository implements SprintsRepositoryInterface{
    private $sprintsDb;

    public function __construct(SprintsDbInterface $sprintsDb){
        $this->sprintsDb = $sprintsDb;
    }

    public function listSprints(){
        $filas = $this->sprintsDb->getAll();
        $listaSprints = [];

        foreach($filas as $fila){
            $listaSprints[]= SprintsModelMapper::mapToEntity($fila);
        }
        return $listaSprints;
    }

    public function searchSprintPorId($id){
        $fila = $this->sprintsDb->getById($id);
        if (!$fila) {
            return null;
        }
        return SprintsModelMapper::mapToEntity($fila);
    }

    public function saveSprint($sprint){
        return $this->sprintsDb->insert($sprint);
    }
}