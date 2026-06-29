<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Controller\UserController;
use App\Service\GameTypeService;
use App\Service\Tournamentservice;
use App\Helper\ViewHelper;

class TournamentController extends BaseController {
    private TournamentService $tournament;
    private array $gameTypes;

    public function __construct() {
        $this->tournament = new TournamentService();
        $this->gameTypes = (new GameTypeService())->getGameTypeAll();
    }

    private function fillTournamentsGameType(array $tournaments) {
        if (count($tournaments) > 0) {
            // Add reference to $tournament to update its value
            foreach($tournaments as &$tournament) {
                foreach($this->gameTypes as $gameType) {
                    if ($gameType['ID'] == $tournament['game_id']) {
                        $tournament['gameType'] = $gameType['name'];
                        break;
                    }
                }
                if (!isset($tournament['gameType'])) {
                    $tournament['gameType'] = 'not found';
                }
            }
        }
        return $tournaments;
    }

    private function fillTournamentPlayersCount(array $tournaments) {
        if (count($tournaments) > 0) {
            // Add reference to $tournament to update its value
            foreach($tournaments as &$tournament) {
                $tournament['players_count'] = 0;
            }
        }
        return $tournaments;
    }

    private function fillTournamentrounds(array $tournaments) {
        if (count($tournaments) > 0) {
            // Add reference to $tournament to update its value
            foreach($tournaments as &$tournament) {
                $tournament['rounds'] = 0;
            }
        }
        return $tournaments;
    }

    private function getTournamentsFull() {
        $tournaments = $this->tournament->getTournamentAll();
        $tournaments = $this->fillTournamentsGameType($tournaments);
        $tournaments = $this->fillTournamentPlayersCount($tournaments);
        $tournaments = $this->fillTournamentrounds($tournaments);
        return $tournaments;
    }

    private function getTournamentFull(string $id) {
        $tournament = $this->tournament->getTournament($id);
        $tournament = $this->fillTournamentsGameType([$tournament])[0];
        $tournament = $this->fillTournamentPlayersCount([$tournament])[0];
        $tournament = $this->fillTournamentrounds([$tournament])[0];
        return $tournament;
    }

    public function index() {
        $tournaments = $this->getTournamentsFull();
        ViewHelper::loadWithMasterView('views/tournament/index.php', ['tournaments' => $tournaments]);
    }

    public function show(string $id) {
        $userId = $_SESSION['user_id'];
        if (empty($userId)) {
            $userController = new UserController();
            $userController->logout(true);
            exit(0);
        }
        $tournament = $this->getTournamentFull($id);
        $userJoined = $this->tournament->hasUserJoined($userId, $id);
        ViewHelper::loadWithMasterview('views/tournament/show.php', [
            'tournament' => $tournament,
            'userJoined' => $userJoined,
        ]);
    }

    public function create() {
        ViewHelper::loadWithMasterView('views/tournament/create.php', ['gameTypes' => $this->gameTypes]);
    }
    public function store() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $input = [];
        $input['name'] = $data['name'] ?? '';
        $input['gameType'] = $data['gameType'] ?? '';
        $response = $this->tournament->storeTournament($input);
        
        return $this->jsonResponse($response, $response['code']);
    }

    public function join(string $id) {
        $userId = $_SESSION['user_id'];
        if (empty($userId)) {
            $userController = new UserController();
            $userController->logout(true);
            exit(0);
        }
        $response = $this->tournament->joinPlayerToTournament($_SESSION['user_id'], $id);
        return $this->jsonResponse($response, $response['code']);
    }
}
