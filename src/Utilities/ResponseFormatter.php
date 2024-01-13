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
            $this->addLine($counter . ' | ' . $technology);
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


    public function addSimpleLine(?string $line): void
    {
        $this->addLine($line);
    }

    public function addCheatsheetSummary(array $cheatsheets, string $baseUrl): void
    {
        $this->addLine(BashColorizer::printInRed("Here are your cheatsheets:"));
        $this->addLine(BashColorizer::printInRed("-----------------------------"));
        foreach ($cheatsheets as $cheatsheet) {
            $this->addLine(BashColorizer::printInGreen($cheatsheet));
        }
        $this->addLine(BashColorizer::printInRed("-----------------------------"));
        $this->addLine(BashColorizer::printInRed("Make a request to one of these endpoints"));
        $this->addLine("");
        $this->addLine("to get the full cheatsheet:");
        $this->addLine(BashColorizer::printInYellow($baseUrl));
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


    private function addLine(?string $line = ''): void
    {
        if ($line === null) {
            $this->responseText .= "\n";
        } else {
            $this->responseText .= $line . "\n";
        }
    }


    public function getFormattedText(): string
    {
        return $this->responseText;
    }


    /**
     * @param CheatSheet $cheatSheet
     * @param integer[] $visibleIndexes
     * @return void
     */
    public function printCheatSheet(CheatSheet $cheatSheet, array $visibleIndexes): void
    {
        // we want to show first the sections that are in the visibleIndexes array
        // all the sections which are not in the visible indexes should only show their title

        // header
        $this->addLine();

        $sections = $cheatSheet->getMarkdownSections();
        foreach ($sections as $index => $section) {
            $indexStartingFrom1 = $index + 1; // we want to start at 1
            $this->addTitleLine($section->getTitle(), $section->getSlug(), $indexStartingFrom1);
            //  TODO  add slug

            foreach ($section->getContent() as $line) {
                // we only show the content of the line if the index is in the visibleIndexes array
                if (in_array($index, $visibleIndexes, true)) {
                    $lineLength = strlen($line);
                    if ($lineLength === 0) {
                        $this->addLine('');
                        continue;
                    }
                    if ($line[0] === "`" && $line[$lineLength - 1] === "`") {
                        $this->addCodeLine($line);
                        continue;
                    }
                    $this->addNormalLine($line);
                }
            }
        }

        // footer
        $this->addLine('');
    }


    public function addTitleLine(string $title, string $slug, int $index): void
    {
        $lineWithoutHashtag = trim(substr($title, 1));
        $lineWithoutHashtag = $index . ' | ' . $lineWithoutHashtag;
        $this->addLine(
            BashColorizer::printInBlackOnRedBackground('> ' . $index . ' | ')
            . BashColorizer::printInRed($title)
            . ' '
            . BashColorizer::printInBold('/')
            . BashColorizer::printInYellow($slug)
        );
    }

    public function addCodeLine(string $line): void
    {
        $lineLength = strlen($line);
        $lineWithoutBacktick = substr($line, 1, $lineLength - 2);
        $this->addLine(BashColorizer::printInGreen($lineWithoutBacktick));
    }

    public function addNormalLine(string $line): void
    {
        $this->addLine($line);
    }

}
