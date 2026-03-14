<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class Tag
{
    /**
     * @param string[] $keywords
     */
    public function __construct(
        public int $id,
        public string $slug,
        public string $name,
        public ?string $description,
        public array $keywords,
        public string $color,
        public string $createdAt,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id:          (int) $data['id'],
            slug:        (string) ($data['slug'] ?? ''),
            name:        (string) ($data['name'] ?? ''),
            description: isset($data['description']) ? (string) $data['description'] : null,
            keywords:    array_map('strval', (array) ($data['keywords'] ?? [])),
            color:       (string) ($data['color'] ?? ''),
            createdAt:   (string) ($data['created_at'] ?? ''),
        );
    }
}
