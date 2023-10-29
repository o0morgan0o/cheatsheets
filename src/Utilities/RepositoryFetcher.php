<?php
use App\Utilities\ResponseFormatter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RepositoryFetcher
{

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $repoUrl,
        private string $repoContentUrl,
        private string $branch,
    ) {
    }

    private function getHelpFileContent(): array
    {
        // get help.txt from repository
        $helpFileResponse = $this->httpClient->request(
            'GET',
            $this->repoUrl . '/' . $this->branch . '/help.txt'
        );
        $helpFileContent = "";

        $statusCode = $helpFileResponse->getStatusCode();
        if ($statusCode == 200) {
            $helpFileContent = $helpFileResponse->getContent();
        } else {
            $helpFileContent = "No help.txt file found in repository";
        }

        return array(
            'error' => $statusCode != 200,
            'content' => $helpFileContent,
        );
    }

    /**
     * 
     * get a list of files and folders from repository
     * this list will be filtered to keep only the folders
     */
    private function getFileListing(): array
    {
        $folderConstantResponse = $this->httpClient->request(
            'GET',
            $this->repoContentUrl
        );
        $statusCode = $folderConstantResponse->getStatusCode();
        $responseList = $folderConstantResponse->toArray();
        $fileListing = array();
        if ($statusCode == 200) {
            foreach ($responseList as $fileOrFolder) {
                if ($fileOrFolder['type'] == 'dir') {
                    $fileListing[] = $fileOrFolder['name'];
                }
            }
        } else {
        }
        return array(
            'error' => $statusCode != 200,
            'content' => $fileListing,
        );

    }

    public function getRepoResponse(): Response
    {
        $content = "";
        $formatter = new ResponseFormatter();
        $formatter->addContentBlock($this->getHelpFileContent());
        $formatter->addContentBlock($this->getFileListing());

        $response = new Response($formatter->getFormattedText(), 200);
        $response->headers->set("Content-Type", "text/plain");
        return $response;
    }
}