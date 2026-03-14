<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Law4Devs\Client;

$apiKey  = $_ENV['LAW4DEVS_API_KEY'] ?? getenv('LAW4DEVS_API_KEY') ?: '';
$baseUrl = $_ENV['LAW4DEVS_BASE_URL'] ?? getenv('LAW4DEVS_BASE_URL')
    ?: ($apiKey === '' ? 'https://demo.law4devs.eu/api/v1' : 'https://api.law4devs.eu/v1');

$client = new Client(apiKey: $apiKey, baseUrl: $baseUrl);

echo "Using: $baseUrl\n\n";

// List all frameworks
$page = $client->frameworks->list();
printf("Found %d frameworks\n", $page->meta->total);

foreach ($page->data as $fw) {
    printf("  %-12s %s\n", $fw->slug, $fw->name);
}

// List first 5 CRA articles
echo "\nFirst 5 CRA articles:\n";
$articles = $client->articles->list('cra', perPage: 5);

foreach ($articles->data as $article) {
    printf("  Art. %-4s %s\n", $article->articleNumber, $article->title);
}

// Search
echo "\nSearch: 'breach notification'\n";
$results = $client->search->query('breach notification');
printf("Found %d results\n", $results->meta->total);

foreach ($results->data as $result) {
    printf("  [%s] %s — %s\n", strtoupper($result->frameworkSlug), $result->type, $result->title ?? $result->matchContext);
}
