<?php

namespace Modules\Comparator\Helpers\Services;

use Modules\Comparator\Interfaces\RepositoryInterface;
use GuzzleHttp\Exception\ClientException;
use Str;

class Github implements RepositoryInterface
{
    public function find(string $name)
    {
        $formattedName = $this->cutName($name);

        try {
            $response = $this->client('repos/')->request('GET', $formattedName);
        } catch(ClientException $e) {
            return [
                'status' => 'error',
                'message' => $e->getResponse()->getReasonPhrase(),
                'status_code' => $e->getResponse()->getStatusCode(),
            ];
        }

        $result = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $result['last_release_date'] = $this->getLastReleaseDate($formattedName);
        $result['pull_requests_data'] = $this->getPullRequestsData($formattedName);

        return [
            'status' => 'success',
            'data' => $result
        ];
    }

    public function getLastReleaseDate(string $name)
    {
        try {
            $response = $this->client('repos/')->request('GET', $name.'/releases/latest');
        } catch(ClientException $e) {
            return 'NOT FOUND';
        }
        
        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        
        return $data['published_at'];
    }

    public function getPullRequestsData(string $name)
    {
        try {
            $response = $this->client('repos/')->request('GET', $name.'/pulls?state=all');
        } catch(ClientException $e) {
            return [
                'open' => 'NOT FOUND',
                'closed' => 'NOT FOUND',
            ];
        }

        $pullRequests = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $openRequests = 0;
        $closedRequests = 0;

        foreach($pullRequests as $pullRequest)
        {
            $pullRequest['state'] == 'closed' ? $closedRequests++ : $openRequests++;
        }

        return [
            'open' => $openRequests == 30 ? '30+' : $openRequests,
            'closed' => $closedRequests == 30 ? '30+' : $closedRequests,
        ];
    }

    private function cutName(string $name)
    {
        !Str::contains($name, 'https://github.com/') ?: $name = Str::replaceFirst('https://github.com/', '', $name);
        !Str::startsWith($name, '/') ?: $name = Str::replaceFirst('/', '', $name);
        !Str::endsWith($name, '/') ?: $name = Str::replaceLast('/', '', $name);
  
        return $name;
    }

    private function client(?string $category = null)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => "https://api.github.com/$category"]);

        return $client;
    }
}