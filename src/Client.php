<?php

declare(strict_types=1);

namespace Law4Devs;

use Law4Devs\Resources\AnnexesResource;
use Law4Devs\Resources\ArticlesResource;
use Law4Devs\Resources\ComplianceResource;
use Law4Devs\Resources\FrameworksResource;
use Law4Devs\Resources\RecitalsResource;
use Law4Devs\Resources\RequirementsResource;
use Law4Devs\Resources\SearchResource;
use Law4Devs\Resources\TagsResource;

/**
 * Official PHP client for the Law4Devs EU Regulatory Compliance API.
 *
 * Usage:
 *
 *     $client = new \Law4Devs\Client(apiKey: $_ENV['LAW4DEVS_API_KEY']);
 *     $page = $client->frameworks->list();
 *     echo $page->data[0]->name; // e.g. "Cyber Resilience Act"
 */
final class Client
{
    public readonly FrameworksResource $frameworks;
    public readonly ArticlesResource $articles;
    public readonly RecitalsResource $recitals;
    public readonly RequirementsResource $requirements;
    public readonly TagsResource $tags;
    public readonly ComplianceResource $compliance;
    public readonly AnnexesResource $annexes;
    public readonly SearchResource $search;

    public function __construct(
        string $apiKey = '',
        string $baseUrl = HttpClient::DEFAULT_BASE_URL,
        int $timeout = 30,
        int $maxRetries = 3,
    ) {
        $http = new HttpClient(
            baseUrl:    $baseUrl,
            apiKey:     $apiKey,
            timeout:    $timeout,
            maxRetries: $maxRetries,
        );

        $this->frameworks   = new FrameworksResource($http);
        $this->articles     = new ArticlesResource($http);
        $this->recitals     = new RecitalsResource($http);
        $this->requirements = new RequirementsResource($http);
        $this->tags         = new TagsResource($http);
        $this->compliance   = new ComplianceResource($http);
        $this->annexes      = new AnnexesResource($http);
        $this->search       = new SearchResource($http);
    }
}
