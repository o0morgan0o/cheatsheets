<?php

namespace App\Controller;

use App\Services\EnvironmentService;
use RepositoryFetcher;
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

        $repositoryFetcher = new RepositoryFetcher($httpClient, $repoUrl, $repoContentUrl, $branch);

        $response = $repositoryFetcher->getRepoResponse();
        return $response;
    }
}