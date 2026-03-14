<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\Tag;
use Law4Devs\Pagination\Page;

final class TagsResource extends BaseResource
{
    /**
     * List all tags (optionally filtered by framework).
     *
     * @return Page<Tag>
     */
    public function list(?string $frameworkSlug = null, ?int $page = null, ?int $perPage = null): Page
    {
        $params = $this->pageParams($page, $perPage);
        if ($frameworkSlug !== null) {
            $params['framework'] = $frameworkSlug;
        }

        $raw = $this->http->get('/tags', $params);
        return $this->parsePage($raw, Tag::fromArray(...));
    }

    /**
     * Get a single tag by slug.
     */
    public function get(string $slug): Tag
    {
        $raw = $this->http->get('/tags/' . $slug);
        return Tag::fromArray($raw['data'] ?? $raw);
    }

    /**
     * Iterate over all tags.
     *
     * @return \Generator<int, Tag>
     */
    public function iter(?string $frameworkSlug = null, int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), $frameworkSlug, perPage: $perPage);
    }
}
