<?php

namespace App\Service\Production;

use GuzzleHttp\Client;
use App\Service\FetchDataInterface;

class FetchData implements FetchDataInterface
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->api_token = env("GITHUB_API_TOKEN");
        $this->method = "GET";
        $this->baseurl = "https://api.github.com/";
        $this->name = "SakaiTaka23";
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
        $url = $this->baseurl . "users/" . $this->name;
        $response = json_decode($this->client->request($this->method, $url)->getBody(), true);
        $publicRepo = $response['public_repos'];
        $followers = $response['followers'];
        return [$publicRepo, $followers];
    }

    public function commitStar()
    {
        $commitCount = 0;
        $starCount = 0;
        $url = $this->baseurl . "users/" . $this->name . "/repos";
        $response = json_decode($this->client->request($this->method, $url)->getBody(), true);
        foreach ($response as $item) {
            if ($item['fork']) {
                continue;
            }
            $starCount += $item['stargazers_count'];
            $fullname = $item['full_name'];
            $page = 1;
            $url = 'https://api.github.com/repos/' . $fullname . '/commits?per_page=100&page=' . $page;
            while (true) {
                $res = json_decode($this->client->request($this->method, $url)->getBody(), true);
                $commitCount += count($res);
                if (count($res) == 0) {
                    break;
                }
                $page++;
                var_dump($commitCount, $starCount);
            }
        }
        return [$commitCount, $starCount];
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
