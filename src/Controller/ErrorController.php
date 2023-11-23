<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(): Response
    {
        $response = new Response("Uh oh, something went wrong", 404);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
}
