<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MenuRepositories;

class MenuController extends Controller
{
    private $menuRepositories;

    public function __construct(MenuRepositories $menuRepositories)
    {
        $this->menuRepositories = $menuRepositories;
    }

    public function getListMenu ()
    {
        return $this->menuRepositories->getListMenu();
    }

    public function getListCategory ()
    {
        return $this->menuRepositories->getListCategory();
    }
}
