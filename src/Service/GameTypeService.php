<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\GameTypeModel;

class GameTypeService {
    private GameTypeModel $gameType;

    public function __construct() {
        $this->gameType = new GameTypeModel();
    }

    public function getGameTypeAll() {
        return $this->gameType->getGameTypeAll();
    }

    public function getGameType(int $id) {
        try {
            $gameType = $this->gameType->getGameTypeById($id);
            return $gameType;
        } catch(Exception $e) {
            return false;
        }
    }

    public function storeGameType(array $data) {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            $input = [];
            $input['name'] = $data['name'] ?? '';
            $input['version'] = $data['version'] ?? '';
            if (empty($input['name']) || empty($input['version'])) {
                http_response_code(400);
                return ['error' => 'name and version are required', 'code' => 400];
            }

            $gameTypeId = $this->gameType->storeGameType(
                $input['name'],
                $input['version'],
            );
            return [
                'success' => true,
                'message' => 'game type created successfully',
                'gameTypeId' => $gameTypeId,
                'code' => 200
            ];
        } catch(Exception $e) {
            return ['error' => $e->getMessage(), 'code' => 500];
        }
    }
}
