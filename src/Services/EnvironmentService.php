<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class EnvironmentService
{

    public function __construct(
        private $repoBaseUrl,
        private $repoContentUrl,
        private $repoBranch,
    ) {
    }


    public function getRepoBaseUrl(): string
    {
        return $this->repoBaseUrl;
    }

    public function getRepoBranch(): string
    {
        return $this->repoBranch;
    }

    public function getRepoContentUrl(): string
    {
        return $this->repoContentUrl;
    }

}