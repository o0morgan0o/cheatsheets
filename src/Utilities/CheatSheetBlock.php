<?php

namespace App\Utilities;

class CheatSheetBlock
{
        private string $title = '';
        private string $slug = '';
        private array $content = [];

        public function __construct()
        {
        }

        public function setTitle(string $title): void
        {
            $this->title = $title;
        }

        public function setSlug(string $slug): void
        {
            $this->slug = $slug;
        }

        public function addContent(string $content): void
        {
            $this->content[] = $content;
        }

        public function getTitle(): string
        {
            return $this->title;
        }

        public function getSlug(): string
        {
            return $this->slug;
        }

    /**
     * @return string[]
     */
        public function getContent(): array
        {
            return $this->content;
        }


}
