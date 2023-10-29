<?php
namespace App\Utilities;

class ResponseFormatter
{

    private $responseText;

    public function __construct()
    {
        $this->responseText = "";
    }

    private function addHeader()
    {
        $this->responseText .= "======================\n";
        $this->responseText .= "DOTFILES CATALOG\n";
        $this->responseText .= "======================\n";

    }

    private function addFileWithHint(string $name, string $hint): void
    {
        $this->addLine("---------");
        $this->addLine($name);
        $this->addLine($hint);
        $this->addLine("---------");
    }

    public function addContentBlock($content): void
    {
        $counter = 0;
        foreach ($content as $technology) {
            $this->addLine(strval($counter) . ' | ' . $technology);
            $this->addLine("---------");
            $counter++;
        }
        $this->addLine("");
    }

    public function addHeaderContentBlock($content): void
    {
        $this->addLine("---------");
        $this->addLine($content);
        $this->addLine("---------");
    }

    public function addDotfileListInTechnology(array $dotfileListInTechnology): void
    {
        $dotfiles = $dotfileListInTechnology['dotfiles'];
        $counter = 0;
        foreach ($dotfiles as $dotfile) {
            $dotfileTitle = $dotfile["dotfile"];
            $dotfileHint = $dotfile["hint"];
            $this->addLine("---------");
            $this->addLine(strval($counter) . ' | ' . $dotfileTitle);
            $this->addLine($dotfileHint);
            $counter++;

        }
    }

    public function addDotfileWithDocumentationContentBlock(array $dotfileWithDocumentation)
    {
        $documentation = $dotfileWithDocumentation['documentation'];
        $dotfile = $dotfileWithDocumentation['content'];

        $this->addLine("---------");
        $this->addLine($documentation);
        $this->addLine($dotfile);
        $this->addLine("---------");

    }


    private function addLine($line)
    {
        $this->responseText .= $line . "\n";
    }


    public function getFormattedText(): string
    {
        return $this->responseText;
    }


}