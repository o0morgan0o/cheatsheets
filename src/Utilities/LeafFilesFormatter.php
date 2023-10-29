<?php
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LeafFilesFormatter
{
    public function __construct(

        private HttpClientInterface $httpClient,
        private string $repoUrl,
        private string $branch,
        private string $path,
        private array $filesAndFolders
    ) {

    }

    public function getFilteredArray(): array
    {
        // first we need to remove the help.txt file
        $fileListing = [];
        foreach ($this->filesAndFolders as $fileOrFolder) {
            if ($fileOrFolder['name'] == 'help.txt') {
                // unset($this->filesAndFolders[$fileOrFolder]);
                continue;
            }
            // we want to want to show the documentations
            if ($this->endsWith($fileOrFolder['name'], '.md')) {
                continue;
            }
            // all remaining files should be OK

            // each time we add a file we want to fetch the documentation file, which is the file name with json.doc
            // client fetch file

            $url = $this->repoUrl . '/' . $this->branch . '/' . $this->path . '/' . $fileOrFolder['name'] . '.md';
            $hintRequest = $this->httpClient->request(
                'GET',
                $url
            );
            if ($hintRequest->getStatusCode() != 200) {
                $hintContent = "No documentation found";
            } else {
                $hintContent = $hintRequest->getContent();
            }
            $fileListing[] = array(
                "name" => $fileOrFolder['name'],
                "hint" => $hintContent
            );

        }
        return $fileListing;

    }

    private function endsWith($haystack, $needle)
    {
        return (strpos(strrev($haystack), strrev($needle)) === 0);
    }
}