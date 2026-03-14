<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class Annex
{
    public function __construct(
        public int $id,
        public string $frameworkSlug,
        public string $annexNumber,
        public string $title,
        public string $content,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $fw = is_array($data['framework'] ?? null) ? $data['framework'] : [];

        return new self(
            id:            (int) $data['id'],
            frameworkSlug: (string) ($data['framework_slug'] ?? $fw['slug'] ?? ''),
            annexNumber:   (string) ($data['annex_number'] ?? ''),
            title:         (string) ($data['title'] ?? ''),
            content:       (string) ($data['content'] ?? ''),
        );
    }
}
