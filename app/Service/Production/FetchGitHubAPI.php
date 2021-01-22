<?php

namespace App\Service\Production;

use App\Repositories\UserRepositoryInterface;
use GuzzleHttp\Client;
use App\Service\FetchGitHubAPIInterface;
use Exception;

class FetchGitHubAPI implements FetchGitHubAPIInterface
{
    public function __construct(Client $client, UserRepositoryInterface $repository)
    {
        $this->client = $client;
        $this->method = "GET";
        $this->baseurl = "https://api.github.com/";
        $this->options = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . env("GITHUB_API_TOKEN"),
            ]
        ];
        $this->repository = $repository;
    }

    public function Issues(string $name): int
    {
        $url = $this->baseurl . "search/issues?q=+is:issue+user:" . $name;
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        $issues = $response['total_count'];
        return intval($issues);
    }

    public function PullRequests(string $name): int
    {
        $url = $this->baseurl . "search/issues?q=is:pr+author:" . $name;
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        $pullRequest = $response['total_count'];
        return intval($pullRequest);
    }

    public function publicRepoFollowers(string $name): array
    {
        $url = $this->baseurl . "users/" . $name;
        $response = json_decode($this->client->request($this->method, $url, $this->options)->getBody(), true);
        $publicRepo = $response['public_repos'];
        $followers = $response['followers'];
        return [$publicRepo, $followers];
    }

    public function commitStar(string $name): array
    {
        $commitCount = 0;
        $starCount = 0;
        $url = $this->baseurl . "users/" . $name . "/repos";
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

    public function summarizeData(string $name): void
    {
        // publicRepo followers
        list($publicRepo, $followers) = $this->publicRepoFollowers($name);
        // pullRequests
        $pullRequest = $this->PullRequests($name);
        // issues
        $issues = $this->Issues($name);
        // commitSum starSum
        list($commitSum, $starSum) = $this->commitStar($name);

        $summarizedData = array($publicRepo, $commitSum, $issues, $pullRequest, $starSum, $followers);

        $this->repository->setUserStats($name, $publicRepo, $commitSum, $issues, $pullRequest, $starSum, $followers);
    }
}
