<?php
class HistoryController implements HistoryControllerInterface
{
    private $historiasRepository;
    private $sprintsRepository;

    public function __construct(HistoryRepositoryInterface $historiasRepository, SprintsRepositoryInterface $sprintsRepository)
    {
        $this->historiasRepository = $historiasRepository;
        $this->sprintsRepository = $sprintsRepository;
    }

    public function getAllHistory()
    {
        return $this->historiasRepository->listHistory();
    }

    public function getHistoryById($id)
    {
        return $this->historiasRepository->searchHistoryById($id);
    }

    public function createHistory($datos)
    {
        $historia = HistoryControllerMapper::mapRequestToEntity($datos);
        return $this->historiasRepository->saveHistory($historia);
    }

    public function updateHistory($datos)
    {
        $historia = HistoryControllerMapper::mapRequestToEntity($datos);
        return $this->historiasRepository->editHistory($historia);
    }

    public function deleteHistory($id)
    {
        return $this->historiasRepository->deleteHistory((int)$id);
    }

    public function getHistoryGroupedBySprint()
    {
        $sprints = $this->sprintsRepository->listSprints();
        $agrupado = [];

        foreach ($sprints as $sprint) {
            $historiasDelSprint = $this->historiasRepository->listHistoryBySprint($sprint->id);
            $agrupado[] = [
                'sprint' => $sprint,
                'historias' => $historiasDelSprint
            ];
        }

        return $agrupado;
    }

    public function generateReport()
    {
        $todas = $this->historiasRepository->listHistory();

        $general = [
            'finalizadas' => 0,
            'pendientes' => 0,
            'impedimentos' => 0,
            'total' => count($todas)
        ];

        $porResponsable = [];

        foreach ($todas as $historia) {
            $resp = $historia->responsable;

            if (!isset($porResponsable[$resp])) {
                $porResponsable[$resp] = [
                    'finalizadas' => 0,
                    'pendientes' => 0,
                    'impedimentos' => 0,
                    'total' => 0
                ];
            }

            $porResponsable[$resp]['total']++;

            if($historia->estado==='finalizada'){
                $general['finalizadas']++;
                $porResponsable[$resp]['finalizadas']++;
            } elseif ($historia->estado === 'impedimento'){
                $general['impedimentos']++;
                $porResponsable[$resp]['impedimentos']++;
            } else {
                // Estados 'nueva' y 'activa' cuentan como pendientes
                $general['pendientes']++;
                $porResponsable[$resp]['pendientes']++;
            }
        }

        return [
            'general' => $general,
            'por_responsable' => $porResponsable
        ];
    }
}
