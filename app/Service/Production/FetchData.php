<?php

namespace App\Service\Production;

use GuzzleHttp\Client;
use App\Service\FetchDataInterface;

class FetchData implements FetchDataInterface
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->method = "GET";
        $this->baseurl = "https://api.github.com/";
        $this->name = "";
    }

    public function fetchPublicRepo()
    {
    }

    public function fetchComitSum()
    {
    }

    public function fetchIssues()
    {
        $url = $this->baseurl . "search/issues?q=+is:issue+user:" . $this->name;
        $response = json_decode($this->client->request($this->method, $url)->getBody(), true);
        $issues = $response['total_count'];
        return $issues;
    }

    public function fetchPullRequests()
    {
        $url = $this->baseurl . "search/issues?q=is:pr+author:" . $this->name;
        $response = json_decode($this->client->request($this->method, $url)->getBody(), true);
        $pullRequest = $response['total_count'];
        return $pullRequest;
    }

    public function fetchStarSum()
    {
    }

    public function fetchFollowers()
    {
    }

    public function publicRepoFollowers()
    {
        $url = $this->baseurl + "users/" + $this->name;
    }

    public function commitStar()
    {
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function summarizeData(string $name)
    {
        $this->setName($name);
        // public_repo followers
    }
}
