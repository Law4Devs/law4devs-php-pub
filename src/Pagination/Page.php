<?php

declare(strict_types=1);

namespace Law4Devs\Pagination;

/**
 * A single page of results.
 *
 * @template T
 */
final readonly class Page
{
    /**
     * @param T[] $data
     */
    public function __construct(
        public array $data,
        public PageMeta $meta,
        public PageLinks $links,
    ) {}

    public function count(): int
    {
        return count($this->data);
    }
}
