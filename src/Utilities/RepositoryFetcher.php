<?php

namespace App\Utilities;

use App\Services\EnvironmentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class RepositoryFetcher
{
    var $urlBuilder;
    private string $apiBaseUrl;
    private string $rawContentBaseUrl;
    private  string $branch;

    /**
     * @param EnvironmentService $service
     * @param HttpClientInterface $httpClient
     */
    public function __construct(
        private EnvironmentService $service,
        private HttpClientInterface $httpClient,
    )
    {
        $this->apiBaseUrl = $service->getApiBaseUrl();
        $this->rawContentBaseUrl = $service->getRawContentBaseUrl();
        $this->branch = $service->getRepoBranch();

        $this->urlBuilder = new UrlBuilder($this->apiBaseUrl, $this->rawContentBaseUrl, $this->branch);
    }

    public function getCheatSheet(string $cheatSheet): string | null
    {
        $urlToRequest = $this->urlBuilder->buildUrlForCheatSheet($cheatSheet);
        $response = $this->httpClient->request('GET', $urlToRequest);
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            // TODO log error
            return null;
        }

        try {
            return $response->getContent();
        } catch (ClientExceptionInterface $e) {
            // TODO log error
         return null;
        }
    }


    private function getHelpFileContent($helpFilePath): string
    {
        // get help.txt from repository
        $helpFileUrl = $this->urlBuilder->buildUrlForDotfileContent('', 'help.txt');
        $helpFileResponse = $this->httpClient->request('GET', $helpFileUrl);
        $helpFileContent = "";

        $statusCode = $helpFileResponse->getStatusCode();
        if ($statusCode == 200) {
            $helpFileContent = $helpFileResponse->getContent();
        } else {
            $helpFileContent = "No help.txt file found in repository";
        }

        return $helpFileContent;
    }

    private function getRootFileListing() : array
    {
        $url = $this->urlBuilder->buildUrlForRootTechnologyListing();
        $folderContentResponse = $this->httpClient->request('GET', $url);
        $statusCode = $folderContentResponse->getStatusCode();
        $responseList = $folderContentResponse->toArray();
        $technologyListing = array();
        foreach ($responseList as $fileOrFolder) {
            // check that we have a file finishing with .md
            if ($fileOrFolder['type'] === 'file' && FilePathUtilities::endsWith($fileOrFolder['name'], '.md')) {
                $technologyListing[] = $fileOrFolder['name'];
            }
        }
        return $technologyListing;
    }


    private function getTechnologyFileListing(string $technology)
    {
        $url = $this->urlBuilder->buildUrlForTechnologyListing($technology);
        $folderContentResponse = $this->httpClient->request('GET', $url);
        $statusCode = $folderContentResponse->getStatusCode();
        $responseList = $folderContentResponse->toArray();
        //
        $fileListing = array();
        foreach ($responseList as $fileOrFolder) {

            // here we must fetch all the children and their documentations
            // but we want to except the help.txt file
            // we also want to skip the documentation at this step, because the documentation will be handled after the dotfile
            if (($fileOrFolder['name'] === 'help.txt') or (FilePathUtilities::endsWith($fileOrFolder['name'], '.md'))) {
                continue;
            }

            // we request the name of the dotfile
            $fileName = $fileOrFolder['name'];
            // we request the content of the documentation 
            $documentationUrl = $this->urlBuilder->buildUrlForDotfileDocumentationContent($technology, $fileName);
            $documentationUrlRequest = $this->httpClient->request('GET', $documentationUrl);
            $documentationStatusCode = $documentationUrlRequest->getStatusCode();
            if($documentationStatusCode !== 200) {
                $documentationContent = "No documentation found";
            }else {
                $documentationContent = $documentationUrlRequest->getContent();
            }

            $fileListing[] = array(
                "dotfile" => $fileName,
                "hint" => $documentationContent
            );
        }
        return array(
            'error' => $statusCode != 200,
            'dotfiles' => $fileListing,
        );

    }

    private function getTechnologyDotFile(string $technology, string $dotfile)
    {
        // get dotfile content
        $url = $this->urlBuilder->buildUrlForDotfileContent($technology, $dotfile);
        try {
            $dotfileRequest = $this->httpClient->request('GET', $url);
            $dotfileStatusCode = $dotfileRequest->getStatusCode();
            $dotfileContent = $dotfileRequest->getContent();
            // get dotfile documentation content
            $urlDocumentation = $this->urlBuilder->buildUrlForDotfileDocumentationContent($technology, $dotfile);
            $dotfileDocumentationRequest = $this->httpClient->request('GET', $urlDocumentation);
            $dotfileDocumentationStatusCode = $dotfileDocumentationRequest->getStatusCode();
            //
            if ($dotfileDocumentationStatusCode !== 200) {
                throw new \RuntimeException("No documentation found");
            }
            $dotfileDocumentationContent = $dotfileDocumentationRequest->getContent();
        } catch (TransportExceptionInterface $e) {
            return array(
                'error' => true,
                'documentation' => "No documentation found",
                'content' => "No content found",
            );
        }
        return array(
            'error' => $dotfileStatusCode !== 200,
            'documentation' => $dotfileDocumentationContent,
            'content' => $dotfileContent,
        );
    }


    public function getRepoResponse(string $technology, DotfileRequestType $requestType, $dotfile = ''): Response
    {
        $formatter = new ResponseFormatter();
        switch ($requestType) {
            case DotfileRequestType::ROOT:
                $formatter->addHeaderContentBlock($this->getHelpFileContent('/help.txt'));
                $formatter->addContentBlock($this->getRootFileListing());
                break;
            case DotfileRequestType::FOLDER:
                $formatter->addDotfileListInTechnology($this->getTechnologyFileListing($technology));
                break;
            case DotfileRequestType::FILE:
                $formatter->addDotfileWithDocumentationContentBlock($this->getTechnologyDotFile($technology, $dotfile));
                break;
        }

        $response = new Response($formatter->getFormattedText(), 200);
        $response->headers->set("Content-Type", "text/plain");
        return $response;
    }

    public function getRootRepoResponse(?string $additionalText = ""): Response
    {
        $rootFileListing = $this->getRootFileListing();

        $formatter = new ResponseFormatter();
        if($additionalText !== null){
            $formatter->addSimpleLine($additionalText);
        }
        $formatter->addCheatsheetSummary($rootFileListing, $this->apiBaseUrl);

        $response =  new Response($formatter->getFormattedText(), 200);
        $response->headers->set("Content-Type", "text/plain");
        return  $response;
    }

    public function getCheatSheetResponse(?string $cheatSheetContent, int $visibleIndex): Response
    {
        $cheatSheetObject = new CheatSheet($cheatSheetContent);

        $visibleIndexes = array($visibleIndex);

        $responseFormatter = new ResponseFormatter();
        $responseFormatter->printCheatSheet($cheatSheetObject, $visibleIndexes);

        $response = new Response($responseFormatter->getFormattedText(), 200);
        $response->headers->set("Content-Type", "text/plain");
        return $response;
    }

}


