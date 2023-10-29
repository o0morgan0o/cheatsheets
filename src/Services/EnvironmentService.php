<?php

namespace App\Services;

class EnvironmentService
{

    public function __construct(
        private $rawContentBaseUrl,
        private $apiBaseUrl,
        private $repoBranch,
    ) {
    }


    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    public function getRepoBranch(): string
    {
        return $this->repoBranch;
    }

    public function getRawContentBaseUrl(): string
    {
        return $this->rawContentBaseUrl;
    }

}