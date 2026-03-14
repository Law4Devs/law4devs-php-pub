<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\Annex;
use Law4Devs\Models\AnnexSummary;
use Law4Devs\Pagination\Page;

final class AnnexesResource extends BaseResource
{
    /**
     * List annexes for a framework.
     *
     * @return Page<AnnexSummary>
     */
    public function list(string $frameworkSlug, ?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get(
            '/frameworks/' . $frameworkSlug . '/annexes',
            $this->pageParams($page, $perPage),
        );
        return $this->parsePage($raw, AnnexSummary::fromArray(...));
    }

    /**
     * Get a single annex.
     */
    public function get(string $frameworkSlug, int|string $annexNumber): Annex
    {
        $raw = $this->http->get('/frameworks/' . $frameworkSlug . '/annexes/' . $annexNumber);
        return Annex::fromArray($raw['data'] ?? $raw);
    }

    /**
     * Iterate over all annexes in a framework.
     *
     * @return \Generator<int, AnnexSummary>
     */
    public function iter(string $frameworkSlug, int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), $frameworkSlug, perPage: $perPage);
    }
}
