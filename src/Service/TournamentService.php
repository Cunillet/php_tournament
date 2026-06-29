<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\TournamentModel;
use App\Model\TournamentPlayerModel;

class TournamentService {
    private TournamentModel $tournament;
    private TournamentPlayerModel $tournamentPlayer;

    public function __construct() {
        $this->tournament = new TournamentModel();
        $this->tournamentPlayer = new TournamentPlayerModel();
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

    public function joinPlayerToTournament(string $userId, string $tournamentId) {
        try {
            $tournamentId = $this->tournamentPlayer->storeTournamentPlayer(
                $userId,
                $tournamentId,
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

    public function hasUserJoined(string $id, string $tournamentId) {
        try {
            return $this->tournamentPlayer->getTournamentPlayer($id, $tournamentId);
        } catch(\Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }
}
