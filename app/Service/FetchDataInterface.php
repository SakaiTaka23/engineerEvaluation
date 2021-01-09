<?php

namespace App\Service;

interface FetchDataInterface
{
    public function fetchPublicRepo();
    public function fetchComitSum();
    public function fetchIssues();
    public function fetchPullRequests();
    public function fetchStarSum();
    public function fetchFollowers();

    public function publicRepoFollowers();
    public function commitStar();

    public function setName(string $name): void;

    public function summarizeData(string $name);
}
