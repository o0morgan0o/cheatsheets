<?php
namespace App\Utilities;

class ResponseFormatter
{

    private $responseText;

    public function __construct()
    {
        $this->responseText = "";
        $this->addHeader();
    }

    private function addHeader()
    {
        $this->responseText .= "======================\n";
        $this->responseText .= "DOTFILES CATALOG\n";
        $this->responseText .= "======================\n";

    }

    public function addContentBlock($content): void
    {
        if ($content['error']) {
            $this->addLine("Error fetching content");
        } else {
            if (is_array($content['content'])) {
                foreach ($content['content'] as $line) {
                    $this->addLine($line);
                }
            } else {
                $this->addLine($content['content']);
            }
        }
        $this->addLine("");
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