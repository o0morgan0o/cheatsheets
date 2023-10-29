<?php
namespace App\Utilities;

use App\Utilities\ResponseFormatter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Utilities\UrlBuilder;


class RepositoryFetcher
{
    var $urlBuilder;

    /**
     * @param HTTPClientInterface $httpClient
     * @param string $repoUrl
     * @param string $repoContentUrl
     * @param string $branch
     */
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiBaseUrl,
        private string $rawContentBaseUrl,
        private string $branch,
    ) {
        $this->urlBuilder = new UrlBuilder($this->apiBaseUrl, $this->rawContentBaseUrl, $this->branch);
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

    private function getRootFileListing()
    {
        $url = $this->urlBuilder->buildUrlForRootTechnologyListing();
        $folderContentResponse = $this->httpClient->request('GET', $url);
        $statusCode = $folderContentResponse->getStatusCode();
        $responseList = $folderContentResponse->toArray();
        $technologyListing = array();
        foreach ($responseList as $fileOrFolder) {
            if ($fileOrFolder['type'] == 'dir') {
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

            // here we must fetch all the children and their documentantions
            // but we want to except the help.txt file
            // we also want to skip the documentation at this step, because the documentation whill be handle after the dotfile
            if (($fileOrFolder['name'] == 'help.txt') or (FilePathUtilities::endsWith($fileOrFolder['name'], '.md'))) {
                continue;
            }

            // we request the name of the dotfile
            $fileName = $fileOrFolder['name'];
            // we request the content of the documentation 
            $documentationUrl = $this->urlBuilder->buildUrlForDotfileDocumentationContent($technology, $fileName);
            $documentationUrlRequest = $this->httpClient->request('GET', $documentationUrl);
            $documentationContent = $documentationUrlRequest->getContent();

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
        $dotfileRequest = $this->httpClient->request('GET', $url);
        $dotfileStatusCode = $dotfileRequest->getStatusCode();
        $dotfileContent = $dotfileRequest->getContent();
        // get dotfile documentation content
        $urlDocumentation = $this->urlBuilder->buildUrlForDotfileDocumentationContent($technology, $dotfile);
        $dotfileDocumentationRequest = $this->httpClient->request('GET', $urlDocumentation);
        $dotfileDocumentationStatusCode = $dotfileDocumentationRequest->getStatusCode();
        $dotfileDocumentationContent = $dotfileDocumentationRequest->getContent();
        //
        if ($dotfileDocumentationStatusCode != 200) {
            $dotfileDocumentationContent = "No documentation found";
        }
        return array(
            'error' => $dotfileStatusCode != 200,
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

}