<?php
class SprintsController implements SprintsControllerInterface{
    private $sprintsRepository;

    public function __construct(SprintsRepositoryInterface $sprintsRepository){
    $this->sprintsRepository = $sprintsRepository;
    }

    public function getAllSprints(){
        return $this->sprintsRepository->listSprints();
    }

    public function getSprintById($id){
        return $this->sprintsRepository->searchSprintPorId($id);
    }

    public function createSprint($datos){
        $sprint = SprintsControllerMapper::mapRequestToEntity($datos);
        return $this->sprintsRepository->saveSprint($sprint);
    }
}