<?php

declare(strict_types=1);

namespace Law4Devs\Pagination;

final readonly class PageMeta
{
    public function __construct(
        public string $apiVersion,
        public int $total,
        public int $page,
        public int $perPage,
        public int $pages,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            apiVersion: (string) ($data['api_version'] ?? '1.0'),
            total:      (int) ($data['total'] ?? 0),
            page:       (int) ($data['page'] ?? 1),
            perPage:    (int) ($data['per_page'] ?? 20),
            pages:      (int) ($data['pages'] ?? 0),
        );
    }
}
