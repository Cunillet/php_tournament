<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Service\GameTypeService;
use App\Helper\ViewHelper;

class GameTypeController extends BaseController {
    private GameTypeService $gameType;

    public function __construct() {
        $this->gameType = new GameTypeService();
    }

    public function index() {
        $gameTypes = $this->gameType->getGameTypeAll();
        ViewHelper::loadWithMasterView('views/gametype/index.php', ['gameTypes' => $gameTypes]);
    }

    public function create() {
        ViewHelper::loadWithMasterView('views/gametype/create.php');
    }

    public function store() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        $input = [];
        $input['name'] = $data['name'] ?? '';
        $input['version'] = $data['version'] ?? '';
        $response = $this->gameType->storeGameType($input);
        
        return $this->jsonResponse($response, $response['code']);
    }
}
