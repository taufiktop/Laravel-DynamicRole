<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ExampleRepositories;

class ExampleController extends Controller
{
    private $exampleRepositories;

    public function __construct(ExampleRepositories $exampleRepositories)
    {
        $this->exampleRepositories = $exampleRepositories;
    }

    public function get ()
    {
        return $this->exampleRepositories->get();
    }

    public function post ()
    {
        return $this->exampleRepositories->post();
    }
}
