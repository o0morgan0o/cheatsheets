<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class DotFilesCatalogControllerTest extends TestCase
{

    var $client;

    public function setUp(): void
    {
        $this->client = new GuzzleHttp\Client([
            'default' => [
                'exceptions' => false
            ],
            // 'debug' => true,
        ]);
    }
    public function testRootCall(): void
    {
        $response = $this->client->request('GET', 'http://localhost:8000/');
        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getBody()->getContents();
        $this->assertStringContainsString('tsconfig', $content);
    }

    public function testTsConfigRootDirectory(): void
    {
        $response = $this->client->request('GET', 'http://localhost:8000/tsconfig');
        $this->assertEquals(200, $response->getStatusCode());
        $content = $response->getBody()->getContents();
        $this->assertStringContainsString('tsconfig.json', $content);

    }
}