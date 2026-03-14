<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class Framework
{
    public function __construct(
        public int $id,
        public string $slug,
        public string $name,
        public string $shortName,
        public string $celexNumber,
        public ?string $description,
        public bool $isActive,
        public string $status,
        public int $expectedArticles,
        public int $expectedRecitals,
        public ?string $lastSyncedAt,
        public string $createdAt,
        public int $articleCount,
        public int $recitalCount,
        public string $eurLexUrl,
        public int $requirementCount,
        public int $annexCount,
        public int $tagCount,
        /** @var array<string, mixed>|null */
        public ?array $coverage,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            id:               (int) $data['id'],
            slug:             (string) ($data['slug'] ?? ''),
            name:             (string) ($data['name'] ?? ''),
            shortName:        (string) ($data['short_name'] ?? ''),
            celexNumber:      (string) ($data['celex_number'] ?? ''),
            description:      isset($data['description']) ? (string) $data['description'] : null,
            isActive:         (bool) ($data['is_active'] ?? true),
            status:           (string) ($data['status'] ?? 'active'),
            expectedArticles: (int) ($data['expected_articles'] ?? 0),
            expectedRecitals: (int) ($data['expected_recitals'] ?? 0),
            lastSyncedAt:     isset($data['last_synced_at']) ? (string) $data['last_synced_at'] : null,
            createdAt:        (string) ($data['created_at'] ?? ''),
            articleCount:     (int) ($data['article_count'] ?? 0),
            recitalCount:     (int) ($data['recital_count'] ?? 0),
            eurLexUrl:        (string) ($data['eurlex_url'] ?? ''),
            requirementCount: (int) ($data['requirement_count'] ?? 0),
            annexCount:       (int) ($data['annex_count'] ?? 0),
            tagCount:         (int) ($data['tag_count'] ?? 0),
            coverage:         isset($data['coverage']) && is_array($data['coverage']) ? $data['coverage'] : null,
        );
    }
}
