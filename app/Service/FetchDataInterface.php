<?php

namespace App\Service;

interface FetchDataInterface
{
    public function fetchIssues(): string;
    public function fetchPullRequests(): string;
    public function publicRepoFollowers(): array;
    public function commitStar(): array;

    public function setName(string $name): void;

    public function summarizeData(string $name);
}
