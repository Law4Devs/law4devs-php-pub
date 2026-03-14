<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class Recital
{
    public function __construct(
        public int $id,
        public string $frameworkSlug,
        public int $recitalNumber,
        public string $content,
        public int $position,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $fw = is_array($data['framework'] ?? null) ? $data['framework'] : [];

        return new self(
            id:            (int) $data['id'],
            frameworkSlug: (string) ($data['framework_slug'] ?? $fw['slug'] ?? ''),
            recitalNumber: (int) ($data['recital_number'] ?? 0),
            content:       (string) ($data['content'] ?? ''),
            position:      (int) ($data['position'] ?? 0),
        );
    }
}
