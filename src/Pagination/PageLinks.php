<?php

declare(strict_types=1);

namespace Law4Devs\Pagination;

final readonly class PageLinks
{
    public function __construct(
        public ?string $next,
        public ?string $prev,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            next: isset($data['next']) ? (string) $data['next'] : null,
            prev: isset($data['prev']) ? (string) $data['prev'] : null,
        );
    }
}
