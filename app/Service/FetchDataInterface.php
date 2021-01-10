<?php

namespace App\Service;

interface FetchDataInterface
{
    public function fetchIssues(): int;
    public function fetchPullRequests(): int;
    public function publicRepoFollowers(): array;
    public function commitStar(): array;

    public function setName(string $name): void;

    public function summarizeData(string $name): array;
}
