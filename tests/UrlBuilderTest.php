<?php
use PHPUnit\Framework\TestCase;

class UrlBuilderTest extends TestCase
{
    var $urlBuilder;
    var $repoBranch;
    var $apiRepoBaseUrl;
    var $rawContentRepoBaseUrl;

    public function setUp(): void
    {
        $this->repoBranch = $_ENV["APP_DOTFILES_REPO_BRANCH"];
        $this->apiRepoBaseUrl = $_ENV["APP_DOTFILES_REPO_API_BASE_URL"];
        $this->rawContentRepoBaseUrl = $_ENV["APP_DOTFILES_REPO_RAW_CONTENT_BASE_URL"];
        $this->urlBuilder = new App\Utilities\UrlBuilder(
            $this->apiRepoBaseUrl,
            $this->rawContentRepoBaseUrl,
            $this->repoBranch
        );
    }
    public function testRootUrl(): void
    {
        $url = $this->urlBuilder->buildUrlForRootTechnologyListing();
        $this->assertEquals(
            "https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents",
            $url
        );
    }

    public function testGetRootHelpFileUrl(): void
    {
        $url = $this->urlBuilder->buildUrlForDotfileContent("/", "help.txt");
        $this->assertEquals(
            "https://raw.githubusercontent.com/o0morgan0o/dev-dotfiles-repo/main/help.txt",
            $url
        );
        $url = $this->urlBuilder->buildUrlForDotfileContent("", "help.txt");
        $this->assertEquals(
            "https://raw.githubusercontent.com/o0morgan0o/dev-dotfiles-repo/main/help.txt",
            $url
        );
    }

    public function testGetTechnologyListingUrl(): void
    {
        $url = $this->urlBuilder->buildUrlForTechnologyListing("tsconfig");
        $this->assertEquals(
            "https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents/tsconfig",
            $url
        );
        $url = $this->urlBuilder->buildUrlForTechnologyListing("/tsconfig");
        $this->assertEquals(
            "https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents/tsconfig",
            $url
        );
    }

    public function testGetDotfileContentUrl(): void
    {
        $url = $this->urlBuilder->buildUrlForDotfileContent("tsconfig", "tsconfig.json");
        $this->assertEquals(
            "https://raw.githubusercontent.com/o0morgan0o/dev-dotfiles-repo/main/tsconfig/tsconfig.json",
            $url
        );
    }

    public function tetGetDotfileDocumentationContentUrl(): void
    {
        $url = $this->urlBuilder->buildUrlForDotfileDocumentationContent("tsconfig", "tsconfig.json");
        $this->assertEquals(
            "https://raw.githubusercontent.com/o0morgan0o/dev-dotfiles-repo/main/tsconfig/tsconfig.json.md",
            $url
        );
    }



}