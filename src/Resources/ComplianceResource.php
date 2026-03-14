<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\ComplianceDeadline;
use Law4Devs\Pagination\Page;

final class ComplianceResource extends BaseResource
{
    /**
     * List compliance deadlines for a framework.
     *
     * @return Page<ComplianceDeadline>
     */
    public function list(string $frameworkSlug, ?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get(
            '/frameworks/' . $frameworkSlug . '/compliance/deadlines',
            $this->pageParams($page, $perPage),
        );
        return $this->parsePage($raw, ComplianceDeadline::fromArray(...));
    }

    /**
     * Iterate over all compliance deadlines in a framework.
     *
     * @return \Generator<int, ComplianceDeadline>
     */
    public function iter(string $frameworkSlug, int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), $frameworkSlug, perPage: $perPage);
    }
}
