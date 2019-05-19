<?php

namespace Modules\Comparator\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Arr;

class RepoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if(Arr::get($this->resource, 'status', 'error') == 'success')
        {
            return [
                'status' => 'success',
                'full_name' => Arr::get($this->resource, 'data.full_name', ''),
                'url' => Arr::get($this->resource, 'data.url', ''),
                'html_url' => Arr::get($this->resource, 'data.html_url', ''),
                'language' => Arr::get($this->resource, 'data.language', ''),
                'forks' => Arr::get($this->resource, 'data.forks_count', 0),
                'stars' => Arr::get($this->resource, 'data.stargazers_count', 0),
                'watchers' => Arr::get($this->resource, 'data.subscribers_count', 0),
                'last_release_date' => Arr::get($this->resource, 'data.last_release_date', 0),
                'open_pull_requests' => Arr::get($this->resource, 'data.pull_requests_data.open', 0),
                'closed_pull_requests' => Arr::get($this->resource, 'data.pull_requests_data.closed', 0),
            ];
        }
        else
        {
            return [
                'status' => 'error',
                'message' => $this->resource['message'],
                'status_code' => $this->resource['status_code'],
            ];
        }
    }
}
