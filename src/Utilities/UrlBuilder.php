<?php

namespace App\Utilities;

class UrlBuilder
{

    public function __construct(
        private string $apiBaseUrl,
        private string $rawContentBaseUrl,
        private string $branch
    )
    {
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
        return str_replace("/", "", $input);
    }

    public function buildUrlForCheatSheet(string $cheatSheet): string
    {
        $sanitizedCheatsheet = $this->sanitizeInput($cheatSheet);
        // if sanitizedCheatSheet don't finish my .md, we add it
        if (!FilePathUtilities::endsWith($sanitizedCheatsheet, '.md')) {
            $sanitizedCheatsheet = $sanitizedCheatsheet . '.md';
        }
        return $this->rawContentBaseUrl . '/' . $this->branch . '/' . $sanitizedCheatsheet;
    }


}
