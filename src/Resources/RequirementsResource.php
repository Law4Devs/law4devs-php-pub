<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\Requirement;
use Law4Devs\Pagination\Page;

final class RequirementsResource extends BaseResource
{
    /**
     * List requirements for a framework.
     *
     * @return Page<Requirement>
     */
    public function list(string $frameworkSlug, ?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get(
            '/frameworks/' . $frameworkSlug . '/requirements',
            $this->pageParams($page, $perPage),
        );
        return $this->parsePage($raw, Requirement::fromArray(...));
    }

    /**
     * Get a single requirement.
     */
    public function get(string $frameworkSlug, int $requirementId): Requirement
    {
        $raw = $this->http->get('/frameworks/' . $frameworkSlug . '/requirements/' . $requirementId);
        return Requirement::fromArray($raw['data'] ?? $raw);
    }

    /**
     * Iterate over all requirements in a framework.
     *
     * @return \Generator<int, Requirement>
     */
    public function iter(string $frameworkSlug, int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), $frameworkSlug, perPage: $perPage);
    }
}
