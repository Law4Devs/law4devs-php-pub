<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Law4Devs\Client;

$client = new Client(apiKey: $_ENV['LAW4DEVS_API_KEY'] ?? getenv('LAW4DEVS_API_KEY') ?: '');

// Auto-paginate all GDPR articles
echo "All GDPR articles:\n";
$count = 0;

foreach ($client->articles->iter('gdpr') as $article) {
    printf("  Art. %-4s %s\n", $article->articleNumber, $article->title);
    $count++;
}

printf("\nTotal: %d articles\n", $count);

// Auto-paginate all NIS2 recitals
echo "\nAll NIS2 recitals:\n";
$recitalCount = 0;

foreach ($client->recitals->iter('nis2') as $recital) {
    printf("  Recital %-4s %.60s\n", $recital->recitalNumber, $recital->content);
    $recitalCount++;
}

printf("\nTotal: %d recitals\n", $recitalCount);
