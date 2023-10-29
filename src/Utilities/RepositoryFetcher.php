<?php
use App\Utilities\ResponseFormatter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RepositoryFetcher
{

    /**
     * @param HTTPClientInterface $httpClient
     * @param string $repoUrl
     * @param string $repoContentUrl
     * @param string $branch
     * @param bool $showContentFilesOnly - if true, only files will be shown, if false, folders will be shown. It is used to show better content if we are on a leaf folder (the end of the request)
     * @param string $path
     */
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $repoUrl,
        private string $repoContentUrl,
        private string $branch,
        private bool $showContentFilesOnly,
        private string $path = ""

    ) {
    }

    private function getHelpFileContent(): array
    {
        // get help.txt from repository
        $url = $this->repoUrl . '/' . $this->branch . '/' . $this->path . '/help.txt';
        $helpFileResponse = $this->httpClient->request(
            'GET',
            $url
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
        $url = $this->repoContentUrl . '/' . $this->path . '?ref=' . $this->branch;
        $folderContentResponse = $this->httpClient->request(
            'GET',
            $url
        );
        $statusCode = $folderContentResponse->getStatusCode();
        $responseList = $folderContentResponse->toArray();
        $fileListing = array();
        if ($statusCode == 200) {
            /* here we want to separate the different cases
            - if we are not on a leaf, we want to show only the directories
            - if we are on a leaf, we want to show the files, but we filter the help.txt and all the documentations
              the documentations must be shown as text for each suggestion, so a special format is needed
            */
            if ($this->showContentFilesOnly) {
                // we are on a leaf, we want to show the files
                $leafFileFormatter = new LeafFilesFormatter($this->httpClient, $this->repoUrl, $this->branch, $this->path, $responseList);
                $leafFileFormatter->getFilteredArray();
                $fileListing = $leafFileFormatter->getFilteredArray();


            } else {
                // we are not on a leaf, we want to show the directories
                foreach ($responseList as $fileOrFolder) {
                    if ($fileOrFolder['type'] == 'dir') {
                        $fileListing[] = array(
                            "name" => $fileOrFolder['name'],
                            "hint" => "This is a directory"
                        );
                    }
                }
            }
        } else {
            // nothing to do
        }
        return array(
            'error' => $statusCode != 200,
            'content' => $fileListing,
        );

    }

    public function getRepoResponse(): Response
    {
        $formatter = new ResponseFormatter();
        $formatter->addContentBlock($this->getHelpFileContent());
        $formatter->addContentBlock($this->getFileListing());

        $response = new Response($formatter->getFormattedText(), 200);
        $response->headers->set("Content-Type", "text/plain");
        return $response;
    }
}