<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\Models\Article;
use Law4Devs\Models\ArticleSummary;
use Law4Devs\Pagination\Page;

final class ArticlesResource extends BaseResource
{
    /**
     * List articles for a framework.
     *
     * @return Page<ArticleSummary>
     */
    public function list(string $frameworkSlug, ?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get(
            '/frameworks/' . $frameworkSlug . '/articles',
            $this->pageParams($page, $perPage),
        );
        return $this->parsePage($raw, ArticleSummary::fromArray(...));
    }

    /**
     * Get a single article.
     */
    public function get(string $frameworkSlug, int|string $articleNumber): Article
    {
        $raw = $this->http->get('/frameworks/' . $frameworkSlug . '/articles/' . $articleNumber);
        return Article::fromArray($raw['data'] ?? $raw);
    }

    /**
     * List articles related to a given article.
     *
     * @return Page<ArticleSummary>
     */
    public function related(string $frameworkSlug, int|string $articleNumber, ?int $page = null, ?int $perPage = null): Page
    {
        $raw = $this->http->get(
            '/frameworks/' . $frameworkSlug . '/articles/' . $articleNumber . '/related',
            $this->pageParams($page, $perPage),
        );
        return $this->parsePage($raw, ArticleSummary::fromArray(...));
    }

    /**
     * Iterate over all articles in a framework.
     *
     * @return \Generator<int, ArticleSummary>
     */
    public function iter(string $frameworkSlug, int $perPage = 20): \Generator
    {
        return $this->iterPages($this->list(...), $frameworkSlug, perPage: $perPage);
    }
}
