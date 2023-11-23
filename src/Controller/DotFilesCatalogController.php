<?php

namespace App\Controller;

use App\Services\EnvironmentService;
use App\Utilities\DotfileRequestType;
use App\Utilities\RepositoryFetcher;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;

class DotFilesCatalogController extends AbstractController
{
    var $repoUrl;
    var $repoContentUrl;
    var $branch;

    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface      $cache,
        private LoggerInterface     $logger,
        EnvironmentService          $environmentService
    )
    {
        $this->repoUrl = $environmentService->getApiBaseUrl();
        $this->repoContentUrl = $environmentService->getRawContentBaseUrl();
        $this->branch = $environmentService->getRepoBranch();
    }

    #[Route('/', name: 'dotfiles_catalog')]
    public function index(
        HttpClientInterface $httpClient,
    ): Response
    {
        return $this->cache->get('root', function (ItemInterface $item) use ($httpClient) {
            $this->logger->info("FETCHING ROOT CATALOG (NO CACHE)");
            $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
            return $repositoryFetcher->getRepoResponse("/", DotfileRequestType::ROOT);
        });
    }


    #[Route('/{folder_id}', name: 'dotfiles_catalog_folder_numbered', requirements: ['folder_id' => '\d+'])]
    public function getFolderNumbered(
        HttpClientInterface $httpClient,
        int                 $folder_id
    ): Response
    {
        return $this->cache->get($folder_id, function (ItemInterface $item) use ($httpClient, $folder_id) {
            $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
            $technologiesNumbered = $repositoryFetcher->getTechnologiesAsArray();
            if (($folder_id >= 0) && ($folder_id <= count($technologiesNumbered))) {
                $technologySelected = $technologiesNumbered[$folder_id];
                return new RedirectResponse("/" . $technologySelected);
            }
            return new RedirectResponse("/error");
        });
    }

    #[Route('/{folder}', name: 'dotfiles_catalog_folder')]
    public function getFolder(
        HttpClientInterface $httpClient,
        string              $folder
    ): Response
    {
        return $this->cache->get($folder, function (ItemInterface $item) use ($httpClient, $folder) {
            $path = $folder;
            $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
            return $repositoryFetcher->getRepoResponse($path, DotfileRequestType::FOLDER);
        });
    }

    #[Route('/{folder}/{file_numbered}',
        name: 'dotfiles_catalog_file_numbered',
        requirements: ['file_numbered' => '\d+'],
        priority: 10)]
    public function getFileNumbered(
        HttpClientInterface $httpClient,
        string              $folder,
        int                 $file_numbered,
    ): Response
    {
        return $this->cache->get($folder . "/" . $file_numbered, function (ItemInterface $item) use ($httpClient, $folder, $file_numbered) {
            $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
            $filesNumbered = $repositoryFetcher->getTechnologyFileListingAsArray($folder);
            if (($file_numbered >= 0) && ($file_numbered < count($filesNumbered))) {
                $fileSelected = $filesNumbered[$file_numbered];
                return new RedirectResponse("/" . $folder . "/" . $fileSelected);
            }
            return new RedirectResponse("/error");
        });

    }

    #[Route("/{folder}/{file}", name: 'dotfiles_catalog_file', priority: 1)]
    public function getFile(
        HttpClientInterface $httpClient,
        string              $folder,
        string              $file
    ): Response
    {
        return $this->cache->get($folder . "/" . $file, function (ItemInterface $item) use ($httpClient, $folder, $file) {
            $repositoryFetcher = new RepositoryFetcher($httpClient, $this->repoUrl, $this->repoContentUrl, $this->branch);
            return $repositoryFetcher->getRepoResponse($folder, DotfileRequestType::FILE, $file);
        });
    }

}
