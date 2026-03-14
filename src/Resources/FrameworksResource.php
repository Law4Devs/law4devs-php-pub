<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\Framework;
use Law4Devs\Models\FrameworkSummary;
use Law4Devs\Pagination\Page;

final class FrameworksResource extends BaseResource
{
    /**
     * List all frameworks.
     *
     * @return Page<FrameworkSummary>
     */
    public function list(?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get('/frameworks', $this->pageParams($page, $perPage));
        return $this->parsePage($raw, FrameworkSummary::fromArray(...));
    }

    /**
     * Get a single framework by slug.
     */
    public function get(string $slug): Framework
    {
        $raw = $this->http->get('/frameworks/' . $slug);
        return Framework::fromArray($raw['data'] ?? $raw);
    }

    /**
     * Iterate over all frameworks.
     *
     * @return \Generator<int, FrameworkSummary>
     */
    public function iter(int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), perPage: $perPage);
    }
}
