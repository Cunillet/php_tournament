<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\TournamentModel;
use App\Model\TournamentPlayerModel;
use App\Model\RoundGameModel;

class TournamentService {
    private TournamentModel $tournament;
    private TournamentPlayerModel $tournamentPlayer;
    private RoundGameModel $roundGame;

    public function __construct() {
        $this->tournament = new TournamentModel();
        $this->tournamentPlayer = new TournamentPlayerModel();
        $this->roundGame = new RoundGameModel();
    }

    public function getTournamentAll() {
        return $this->tournament->getTournamentAll();
    }

    public function getTournament(int $id) {
        try {
            $tournament = $this->tournament->getTournamentById($id);
            return $tournament;
        } catch(Exception $e) {
            return false;
        }
    }

    public function storeTournament(array $data) {
        try {
            $input = [];
            $input['name'] = $data['name'] ?? '';
            $input['gameType'] = $data['gameType'] ?? '';
            if (empty($input['name']) || empty($input['gameType'])) {
                http_response_code(400);
                return ['error' => 'Name and Game Type are required', 'code' => 400];
            }

            $tournamentId = $this->tournament->storeTournament(
                $input['name'],
                $input['gameType'],
            );
            return [
                'success' => true,
                'message' => 'Tournament created successfully',
                'tournamentId' => $tournamentId,
                'code' => 200
            ];
        } catch(\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }

    public function joinPlayerToTournament(string $id, string $userId) {
        try {
            $id = $this->tournamentPlayer->storeTournamentPlayer(
                $id,
                $userId,
            );
            return [
                'success' => true,
                'message' => 'Player joined the Tournament successfully',
                'code' => 200
            ];
        } catch(\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }

    public function getTournamentPlayers(string $id) {
        try {
            return $this->tournamentPlayer->getTournamentPlayersCount($id);
        } catch(\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }

    public function hasUserJoined(string $id, string $userId) {
        try {
            return $this->tournamentPlayer->getTournamentPlayer($id, $userId);
        } catch(\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }

    public function createRound(string $id) {
        try {
            $tournamentPlayers = $this->tournamentPlayer->getTournamentPlayers($id);
            $players = array_column($tournamentPlayers, 'user_id');
            // Shuffle players
            shuffle($players);

            // Check if odd number of players
            if (count($players) % 2 !== 0) {
                // Add a bye (null or 'BYE')
                $players[] = null;
            }

            // Create pairs
            $matches = array_chunk($players, 2);

            // Remove pairs with null
            $matches = array_filter($matches, function($match) {
                return !in_array(null, $match);
            });
            $results = [];
            foreach($matches as $match) {
                $results[] =  $this->roundGame->createRoundGames($id, '1', $match);
            }
            return ['matches' =>$results, 'code' => 200];
        } catch(\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }
}
