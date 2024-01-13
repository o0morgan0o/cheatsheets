<?php

namespace App\Tests;


use App\Utilities\CheatSheet;
use App\Utilities\CheatSheetBlock;
use PHPUnit\Framework\TestCase;

class CheatSheetTest extends TestCase
{
    private  CheatSheet $cheatSheet;
    public function setUp(): void
    {
       $this->cheatSheet = new CheatSheet('');
    }

    public function testParseSlug(): void
    {
        $this->assertEquals( CheatSheet::extractSlugFromString("# (slug: install-alpine)Installation d'alpine"), 'install-alpine' );
        $this->assertEquals( CheatSheet::extractTitleFromString("# (slug: install-alpine)Installation d'alpine"), "Installation d'alpine" );
    }

}
