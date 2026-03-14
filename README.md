# Law4Devs PHP SDK

Official PHP client for the [Law4Devs API](https://law4devs.eu) — structured access to 19 EU regulatory frameworks (GDPR, CRA, NIS2, AI Act, DORA, and more) as JSON.

## Requirements

- PHP 8.1+
- `ext-curl`, `ext-json`

## Installation

```bash
composer require law4devs/law4devs
```

## Quick Start

```php
<?php

require 'vendor/autoload.php';

$client = new \Law4Devs\Client(apiKey: $_ENV['LAW4DEVS_API_KEY']);

// List all frameworks
$page = $client->frameworks->list();
foreach ($page->data as $framework) {
    echo $framework->name . PHP_EOL;
}

// Get a specific framework
$cra = $client->frameworks->get('cra');
echo $cra->name . ': ' . $cra->articleCount . ' articles' . PHP_EOL;
```

## Configuration

```php
$client = new \Law4Devs\Client(
    apiKey:     $_ENV['LAW4DEVS_API_KEY'],
    baseUrl:    'https://api.law4devs.eu',  // optional
    timeout:    30,                          // seconds, optional
    maxRetries: 3,                           // optional
);
```

Set your API key via environment variable:

```bash
export LAW4DEVS_API_KEY=your_api_key_here
```

## Resources

### Frameworks

```php
// List all frameworks (paginated)
$page = $client->frameworks->list(page: 1, perPage: 20);

// Get a framework by slug
$framework = $client->frameworks->get('gdpr');

// Iterate all frameworks without pagination
foreach ($client->frameworks->iter() as $framework) {
    echo $framework->slug . PHP_EOL;
}
```

### Articles

```php
// List articles for a framework
$page = $client->articles->list(frameworkSlug: 'cra', page: 1);

// Get a specific article
$article = $client->articles->get(frameworkSlug: 'cra', articleNumber: '32');

// Iterate all articles in a framework
foreach ($client->articles->iter(frameworkSlug: 'gdpr') as $article) {
    echo $article->title . PHP_EOL;
}
```

### Recitals

```php
// List recitals for a framework
$page = $client->recitals->list(frameworkSlug: 'gdpr');

// Get a specific recital
$recital = $client->recitals->get(frameworkSlug: 'gdpr', recitalNumber: '1');

// Iterate all recitals
foreach ($client->recitals->iter(frameworkSlug: 'nis2') as $recital) {
    echo $recital->number . ': ' . $recital->summary . PHP_EOL;
}
```

### Requirements

```php
// List requirements for an article
$page = $client->requirements->list(frameworkSlug: 'cra', articleNumber: '13');

// Get a specific requirement
$req = $client->requirements->get(
    frameworkSlug: 'cra',
    articleNumber: '13',
    requirementId: 42
);

// Iterate requirements
foreach ($client->requirements->iter(frameworkSlug: 'gdpr', articleNumber: '32') as $req) {
    echo $req->text . PHP_EOL;
}
```

### Annexes

```php
// List annexes for a framework
$page = $client->annexes->list(frameworkSlug: 'cra');

// Get a specific annex
$annex = $client->annexes->get(frameworkSlug: 'cra', annexId: 1);

// Iterate annexes
foreach ($client->annexes->iter(frameworkSlug: 'ai-act') as $annex) {
    echo $annex->title . PHP_EOL;
}
```

### Compliance Deadlines

```php
// List compliance deadlines
$page = $client->compliance->list(frameworkSlug: 'dora');

// Get a specific deadline
$deadline = $client->compliance->get(frameworkSlug: 'dora', deadlineId: 1);

// Iterate all deadlines
foreach ($client->compliance->iter(frameworkSlug: 'nis2') as $deadline) {
    echo $deadline->description . ' — ' . $deadline->date . PHP_EOL;
}
```

### Search

```php
// Search across all frameworks
$results = $client->search->query(q: 'cybersecurity incident reporting');

// Search within a specific framework
$results = $client->search->query(q: 'personal data', frameworkSlug: 'gdpr');

foreach ($results->data as $result) {
    echo '[' . $result->type . '] ' . $result->title . PHP_EOL;
}
```

### Tags

```php
// List all tags
$page = $client->tags->list();

// Get a specific tag
$tag = $client->tags->get('data-protection');

// Iterate all tags
foreach ($client->tags->iter() as $tag) {
    echo $tag->name . PHP_EOL;
}
```

## Pagination

All `list()` methods return a `Page` object:

```php
$page = $client->frameworks->list(page: 1, perPage: 10);

echo $page->meta->total . ' total frameworks' . PHP_EOL;
echo 'Page ' . $page->meta->page . ' of ' . $page->meta->pages . PHP_EOL;

foreach ($page->data as $framework) {
    echo $framework->name . PHP_EOL;
}

// Auto-paginate with iter()
foreach ($client->frameworks->iter() as $framework) {
    // fetches next page automatically when needed
    echo $framework->slug . PHP_EOL;
}
```

## Error Handling

```php
use Law4Devs\Exceptions\AuthenticationException;
use Law4Devs\Exceptions\NotFoundException;
use Law4Devs\Exceptions\RateLimitException;
use Law4Devs\Exceptions\ApiException;

try {
    $framework = $client->frameworks->get('unknown-slug');
} catch (NotFoundException $e) {
    echo 'Not found: ' . $e->getMessage() . PHP_EOL;
} catch (AuthenticationException $e) {
    echo 'Invalid API key' . PHP_EOL;
} catch (RateLimitException $e) {
    echo 'Rate limit exceeded — retry after ' . $e->retryAfter . 's' . PHP_EOL;
} catch (ApiException $e) {
    echo 'API error ' . $e->getCode() . ': ' . $e->getMessage() . PHP_EOL;
}
```

## Documentation

Full API reference and guides: [docs.law4devs.eu/sdks/php](https://docs.law4devs.eu/sdks/php)

## License

MIT — see [LICENSE](LICENSE)
