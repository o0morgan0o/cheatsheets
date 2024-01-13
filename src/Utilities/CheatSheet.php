<?php

namespace App\Utilities;


class CheatSheet
{

    /** @var CheatSheetBlock[] $sections */
    private array $sections = [];
    private string $cheatSheetUrl = "";

    public function __construct(string $cheatSheetContent)
    {
        // cheatSheetContent is a string containing the full content of a cheat sheet
        // we want to parse it to get a correctly parsed object
        $this->parseCheatSheetContent($cheatSheetContent);
    }

    private function parseCheatSheetContent(string $cheatSheetContent): void{

        $lines = explode("\n", $cheatSheetContent);

        $currentSection = new CheatSheetBlock();
        foreach ($lines as $section){
            // if line start by #, it's a section
            // so, we create a new CheatSheetBlock

            if( ($section[0] ?? '') === "#"){
                // if currentSection is not empty, we add it to the sections array
                if($currentSection->getTitle() !== "" || $currentSection->getSlug() !== "" || count($currentSection->getContent()) > 0){
                    // psu to sections
                    $this->sections[] = $currentSection;
                }
                // we start a new section
                $currentSection = new CheatSheetBlock();
                $currentSection->setTitle(self::extractTitleFromString($section));
                $currentSection->setSlug(self::extractSlugFromString($section));
            }else {
                $currentSection->addContent($section);
            }
        }
        // at the end of the loop we add the last section
        $this->sections[] = $currentSection;

    }

    public static function extractSlugFromString(string $title): string{
        $separator = "(slug: ";
        $slugStart = explode( $separator, $title);
        // we found the closing brace
        $slugExplode = explode(")", $slugStart[1]);
        return $slugExplode[0];
    }

    public static function extractTitleFromString(string $title): string{
        $separator = "(slug: ";
        $slugStart = explode( $separator, $title);
        // we found the closing brace
        $slugExplode = explode(")", $slugStart[1]);
        return $slugExplode[1];
    }

    /**
     * @return CheatSheetBlock[]
     */
    public function getMarkdownSections(): array
    {
        return $this->sections;

    }
}
