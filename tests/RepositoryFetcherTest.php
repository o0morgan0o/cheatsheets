<?php
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

// class RespositoryFetcherTest extends WebTestCase
// {

//     public function testRootRepositoryRepoFetcher(): void
//     {
//         $client = self::createClient();
//         $repoUrl = "https://raw.githubuser.content.com/o0morgan0o/dev-dotfiles-repo";
//         $repoContentUrl = "https://api.github.com/repos/o0morgan0o/dev-dotfiles-repo/contents";
//         $response = $client->request(
//             'GET',
//             $repoContentUrl
//         );
//         self::assertResponseIsSuccessful();
//     }
// }