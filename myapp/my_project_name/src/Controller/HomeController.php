<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;


class HomeController
{
    /**
     * @Route("/home")
     */
    public function index()
    {
        return new Response("Hello World");
    }
}
