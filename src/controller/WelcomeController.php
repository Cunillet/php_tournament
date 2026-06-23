<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Helper\ViewHelper;

class WelcomeController extends BaseController
{
    public function index()
    {
        ViewHelper::loadWithMasterView('views/home.php');
    }
}
