<?php

namespace App\Controller;

use App\Services\EnvironmentService;
use App\Utilities\RepositoryFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
        EnvironmentService  $environmentService,
        HttpClientInterface $httpClient,
    ): Response
    {

        $repositoryFetcher = new RepositoryFetcher($environmentService, $httpClient);
        return $repositoryFetcher->getRootRepoResponse();
    }

    #[Route('/{cheatSheet}', name: 'cheatsheet')]
    public function cheatSheet(
        Request             $request,
        LoggerInterface     $logger,
        HttpClientInterface $httpClient,
        string              $cheatSheet
    ): Response
    {
        // we are in the case we look for a cheatsheet without index,
        // we make the request directly to the corresponding route
//        return $this->redirectToRoute('cheatsheet_with_index', ['cheatSheet' => $cheatSheet, 'index' => 0]);
        // TODO not working
//        $scheme = 'http://';
//        $baseUrl = $request->getHttpHost();
//        $urlToFetch = $scheme . $baseUrl . $this->generateUrl('cheatsheet_with_index', ['cheatSheet' => $cheatSheet, 'index' => 0]);
//        try {
//            $innerResponse = $httpClient->request('GET', $urlToFetch);
//            $response = new Response($innerResponse->getContent(), $innerResponse->getStatusCode());
//            $response->headers->set("Content-Type", "text/plain");
//            return $response;
//        } catch (\Exception $e) {
//            return new Response("Error while fetching cheatsheet: " . $e->getMessage(), 500);
//        }
        return new Response("Not implemented", 500);
    }

    #[Route('/{cheatSheet}/{index}', name: 'cheatsheet_with_index')]
    public function cheatSheetWithIndex(
        EnvironmentService  $environmentService,
        LoggerInterface     $logger,
        HttpClientInterface $httpClient,
        string              $cheatSheet,
        string              $index
    ): Response
    {
        // 3 cases
        // if we found a corresponding cheatsheet we return the result
        // if we don't find a corresponding cheatsheet we return a message with suggestions if we found the starting word
        // if we don't find any we send the root file listing

        $logger->info("[+] Request for cheatsheet: " . $cheatSheet . " with index: " . $index);

        // TODO handle case where index is string and index is number
        // let's assume index is a number
        $indexNumber = (int)$index;
        $indexNumber = $indexNumber - 1; // because we want index to start at 1

        // so we try to fetch the cheatsheet
        $repositoryFetcher = new RepositoryFetcher($environmentService, $httpClient);
        $cheatSheetContent = $repositoryFetcher->getCheatSheet($cheatSheet);

        // case 1: we found a corresponding cheatsheet
        if ($cheatSheetContent !== null) {
            return $repositoryFetcher->getCheatSheetResponse($cheatSheetContent, $indexNumber);
        }

        // case 2: we don't find a corresponding cheatsheet we return a message with suggestions if we found the starting word
        // TODO

        // case 3:
        return $repositoryFetcher->getRootRepoResponse("No cheatsheet found at this path: " . $cheatSheet);
    }


}
