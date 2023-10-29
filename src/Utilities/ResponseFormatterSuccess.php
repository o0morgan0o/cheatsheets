<?php
class ResponseFormatterSuccess implements ResponseFormatter
{

    private $responseText;

    public function __construct($statusCode)
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

    public function addLine($line)
    {
        $this->responseText .= $line . "\n";

    }


    public function getFormattedText(): string
    {
        return $this->responseText;
    }


}