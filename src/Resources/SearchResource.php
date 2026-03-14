<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\SearchResult;
use Law4Devs\Pagination\Page;

final class SearchResource extends BaseResource
{
    /**
     * Search across all frameworks.
     *
     * @return Page<SearchResult>
     */
    public function query(
        string $q,
        ?string $framework = null,
        ?string $resultType = null,
        ?int $page = null,
        ?int $perPage = null,
    ): Page {
        $params = array_merge(['q' => $q], $this->pageParams($page, $perPage));

        if ($framework !== null) {
            $params['framework'] = $framework;
        }
        if ($resultType !== null) {
            $params['type'] = $resultType;
        }

        $raw = $this->http->get('/search', $params);
        return $this->parsePage($raw, SearchResult::fromArray(...));
    }
}
