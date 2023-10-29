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

    private function addFileWithHint(string $name, string $hint): void
    {
        $this->addLine("---------");
        $this->addLine($name);
        $this->addLine($hint);
        $this->addLine("---------");
    }

    public function addContentBlock($content): void
    {
        if ($content['error']) {
            $this->addLine("Error fetching content");
        } else {
            if (is_array($content['content'])) {
                foreach ($content['content'] as $line) {
                    if (is_array($line)) {
                        // if we are here, we should have the keys name and hint
                        $this->addFileWithHint($line['name'], $line['hint']);
                    } else {
                        $this->addLine($line);
                    }
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