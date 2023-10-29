<?php

namespace App\Controller;

use App\Services\EnvironmentService;
use App\Utilities\DotfileRequestType;
use App\Utilities\RepositoryFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DotFilesCatalogController extends AbstractController
{
    var $repoUrl;
    var $repoContentUrl;
    var $branch;
    public function __construct(
        private EnvironmentService $environmentService,
        private HttpClientInterface $httpClient,
    ) {
        $this->repoUrl = $environmentService->getApiBaseUrl();
        $this->repoContentUrl = $environmentService->getRawContentBaseUrl();
        $this->branch = $environmentService->getRepoBranch();
    }

    #[Route('/', name: 'dotfiles_catalog')]
    public function index(
        EnvironmentService $environmentService,
        HttpClientInterface $httpClient,
    ): Response {
        $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
        $response = $repositoryFetcher->getRepoResponse("/", DotfileRequestType::ROOT);
        return $response;
    }

    #[Route('/{folder}', name: 'dotfiles_catalog_folder')]
    public function getFolder(
        EnvironmentService $environmentService,
        HttpClientInterface $httpClient,
        string $folder
    ): Response {
        $path = $folder;
        $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
        $response = $repositoryFetcher->getRepoResponse($path, DotfileRequestType::FOLDER);
        return $response;
    }

    #[Route('/{folder}/{file}', name: 'dotfiles_catalog_file')]
    public function getFile(
        EnvironmentService $environmentService,
        HttpClientInterface $httpClient,
        string $folder,
        string $file
    ): Response {
        $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
        $response = $repositoryFetcher->getRepoResponse($folder, DotfileRequestType::FILE, $file);
        return $response;
    }
}