<?php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Utilities\RepositoryFetcher;

class RespositoryFetcherTest extends WebTestCase
{
    public function testRootRepositoryRepoFetcher(): void
    {
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockHttpClient->expects(self::atLeast(1))
            ->method('request')
            ->withConsecutive(
                ['GET', 'https://raw.githubuser.content.com/o0morgan0o/dev-dotfiles-repo/main//help.txt'],
                ['GET', 'https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents/?ref=main']
            )
        ;

        $fetcher = new RepositoryFetcher(
            $mockHttpClient,
            "https://raw.githubuser.content.com/o0morgan0o/dev-dotfiles-repo",
            "https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents",
            "main",
            false
        );
        $fetcher->getRepoResponse();
    }
}