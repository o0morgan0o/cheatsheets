<?php
namespace App\Utilities;

class UrlBuilder
{

    public function __construct(
        private string $apiBaseUrl,
        private string $rawContentBaseUrl,
        private string $branch
    ) {
    }

    public function buildUrlForRootTechnologyListing(): string
    {
        $url = $this->apiBaseUrl;
        return $url;
    }

    public function buildUrlForDotfileContent(string $technology, string $dotfile): string
    {
        $technology = $this->sanitizeInput($technology);
        $dotfile = $this->sanitizeInput($dotfile);
        if ($technology == "") {
            $url = $this->rawContentBaseUrl . '/' . $this->branch . '/' . $dotfile;
        } else {
            $url = $this->rawContentBaseUrl . '/' . $this->branch . '/' . $technology . '/' . $dotfile;

        }
        return $url;
    }

    public function buildUrlForTechnologyListing(string $technology): string
    {
        $technology = $this->sanitizeInput($technology);
        $url = $this->apiBaseUrl . '/' . $technology;
        return $url;
    }

    public function buildUrlForDotfileDocumentationContent(string $technology, string $dotfile): string
    {
        $technology = $this->sanitizeInput($technology);
        $dotfile = $this->sanitizeInput($dotfile);
        $url = $this->rawContentBaseUrl . '/' . $this->branch . '/' . $technology . '/' . $dotfile . '.md';

        return $url;
    }

    private function sanitizeInput(string $input): string
    {
        $input = str_replace("/", "", $input);
        $input = str_replace(" ", "", $input);
        return $input;
    }



}