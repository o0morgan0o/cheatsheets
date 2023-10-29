<?php

namespace App\Controller;

use App\Services\EnvironmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DotFilesCatalogController extends AbstractController
{
    #[Route('/', name: 'dotfiles_catalog')]
    public function index(
        EnvironmentService $environmentService,
        HttpClientInterface $httpClient,
    ): Response {

        $repoUrl = $environmentService->getRepoBaseUrl();
        $repoContentUrl = $environmentService->getRepoContentUrl();
        $branch = $environmentService->getRepoBranch();

        $response = $httpClient->request(
            'GET',
            $repoContentUrl
        );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->toArray();

        $formatter = new \ResponseFormatterSuccess($statusCode);

        $isSuccess = false;
        if ($statusCode == 200) {
            $isSuccess = true;
            foreach ($content as $fileOrFolder) {
                if ($fileOrFolder['type'] == 'dir') {
                    $formatter->addLine($fileOrFolder['name']);
                }

            }

        }

        dd($content);

        $response = new Response($formatter->getFormattedText(), 200);
        $response->headers->set("Content-Type", "text/plain");
        return $response;

    }
}