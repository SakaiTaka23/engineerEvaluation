<?php

namespace App\Service;

interface FetchGitHubAPIInterface
{
    public function Issues(): int;
    public function PullRequests(): int;
    public function publicRepoFollowers(): array;
    public function commitStar(): array;

    public function setName(string $name): void;

    public function summarizeData(string $name): array;
}
