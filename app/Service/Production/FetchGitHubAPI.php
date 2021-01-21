<?php

namespace App\Service\Production;

use GuzzleHttp\Client;
use App\Service\FetchGitHubAPIInterface;
use Exception;

class FetchGitHubAPI implements FetchGitHubAPIInterface
{
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->api_token = env("GITHUB_API_TOKEN");
        $this->method = "GET";
        $this->baseurl = "https://api.github.com/";
        $this->name = "";
        $this->options = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . env("GITHUB_API_TOKEN"),
            ]
        ];
    }

    public function fetchIssues(): int
    {
        $url = $this->baseurl . "search/issues?q=+is:issue+user:" . $this->name;
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        $issues = $response['total_count'];
        return intval($issues);
    }

    public function fetchPullRequests(): int
    {
        $url = $this->baseurl . "search/issues?q=is:pr+author:" . $this->name;
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        $pullRequest = $response['total_count'];
        return intval($pullRequest);
    }

    public function publicRepoFollowers(): array
    {
        $url = $this->baseurl . "users/" . $this->name;
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        $publicRepo = $response['public_repos'];
        $followers = $response['followers'];
        return [$publicRepo, $followers];
    }

    public function commitStar(): array
    {
        $commitCount = 0;
        $starCount = 0;
        $url = $this->baseurl . "users/" . $this->name . "/repos";
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        foreach ($response as $item) {
            if ($item['fork']) {
                continue;
            }
            $starCount += $item['stargazers_count'];
            $fullname = $item['full_name'];
            $page = 1;
            while (true) {
                $url = 'https://api.github.com/repos/' . $fullname . '/commits?per_page=100&page=' . $page;
                // $res = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
                try {
                    $res = $this->client->request($this->method, $url, $this->options);
                    $res = json_decode($res->getBody(), true);
                } catch (Exception $e) {
                    break;
                }
                $commitCount += count($res);
                if (count($res) == 0) {
                    break;
                }
                $page++;
                if ($page > 5) {
                    echo "[ERROR] error happend!!! or commits is more than 400!\n";
                    break;
                }
            }
        }
        return [$commitCount, $starCount];
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function summarizeData(string $name): array
    {
        $this->setName($name);
        // publicRepo followers
        list($publicRepo, $followers) = $this->publicRepoFollowers();
        // pullRequests
        $pullRequest = $this->fetchPullRequests();
        // issues
        $issues = $this->fetchIssues();
        // commitSum starSum
        list($commitSum, $starSum) = $this->commitStar();

        $summarizedData = array($publicRepo, $commitSum, $issues, $pullRequest, $starSum, $followers);
        // return [publicRepo commitSum issues pullRequests starSum followers]
        return $summarizedData;
    }
}
