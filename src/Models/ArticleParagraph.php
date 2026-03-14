<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class ArticleParagraph
{
    public function __construct(
        public string $paragraphRef,
        public string $content,
        public int $position,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            paragraphRef: (string) ($data['paragraph_ref'] ?? ''),
            content:      (string) ($data['content'] ?? ''),
            position:     (int) ($data['position'] ?? 0),
        );
    }
}
