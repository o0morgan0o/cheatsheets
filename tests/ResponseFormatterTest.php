<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Utilities\ResponseFormatter;
use PHPUnit\Runner\BeforeTestHook;

class ResponseFormatterTest extends TestCase
{
    var $responseFormatter;
    public function setUp(): void
    {
        $this->responseFormatter = new ResponseFormatter();
    }
    public function testInsertArrayContent(): void
    {
        $contentArray = array(
            "error" => false,
            "content" => array(
                "help.txt",
                "README.md",
                "src",
                "tests",
            )
        );
        $this->responseFormatter->addContentBlock($contentArray);
        $responseText = $this->responseFormatter->getFormattedText();
        $this->assertStringContainsString("help.txt\nREADME.md\nsrc\ntests\n", $responseText);
    }

    public function testInsertNonArrayContent(): void
    {
        $contentArray = array(
            "error" => false,
            "content" => "This is the help document"
        );
        $this->responseFormatter->addContentBlock($contentArray);
        $responseText = $this->responseFormatter->getFormattedText();
        $this->assertStringContainsString("This is the help document\n", $responseText);

    }
}