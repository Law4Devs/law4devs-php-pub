<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\Recital;
use Law4Devs\Pagination\Page;

final class RecitalsResource extends BaseResource
{
    /**
     * List recitals for a framework.
     *
     * @return Page<Recital>
     */
    public function list(string $frameworkSlug, ?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get(
            '/frameworks/' . $frameworkSlug . '/recitals',
            $this->pageParams($page, $perPage),
        );
        return $this->parsePage($raw, Recital::fromArray(...));
    }

    /**
     * Get a single recital.
     */
    public function get(string $frameworkSlug, int|string $recitalNumber): Recital
    {
        $raw = $this->http->get('/frameworks/' . $frameworkSlug . '/recitals/' . $recitalNumber);
        return Recital::fromArray($raw['data'] ?? $raw);
    }

    /**
     * Iterate over all recitals in a framework.
     *
     * @return \Generator<int, Recital>
     */
    public function iter(string $frameworkSlug, int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), $frameworkSlug, perPage: $perPage);
    }
}
