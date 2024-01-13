<?php

namespace App\Services;

class EnvironmentService
{

    private string $apiBaseUrl ;
    private string $rawContentBaseUrl ;

    public function __construct(
        private $repoBaseUrl,
        private $repoBranch,
    ) {
        $this->apiBaseUrl = $this->generateApiBaseUrl();
        $this->rawContentBaseUrl = $this->generateRawContentBaseUrl();

    }

    /**
     * This method will generate the API base URL from the repo base URL
     * https://github.com/o0morgan0o/dev-dotfiles-repo
     *  to
     *  https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents
     * @return string
     */
    private function generateApiBaseUrl(): string
    {
        $repoBaseUrl = $this->repoBaseUrl;
        $repoBaseUrl = str_replace("https://github.com", "https://api.github.com/repos", $repoBaseUrl);
        $repoBaseUrl = $repoBaseUrl . "/contents";
        return $repoBaseUrl;
    }

    /**
     * This method will generate the raw content base URL from the repo base URL
     * https://github.com/o0morgan0o/dev-dotfiles-repo
     * to
     * https://raw.githubusercontent.com/o0morgan0o/dev-dotfiles-repo
     * @return string
     */
    private function generateRawContentBaseUrl(): string
    {
        $repoBaseUrl = $this->repoBaseUrl;
        $repoBaseUrl = str_replace("https://github.com", "https://raw.githubusercontent.com", $repoBaseUrl);
        return $repoBaseUrl;
    }


    /**
     * @return string
     */
    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    public function getRepoBranch(): string
    {
        return $this->repoBranch;
    }

    public function getRawContentBaseUrl(): string
    {
        return $this->rawContentBaseUrl;
    }

}
