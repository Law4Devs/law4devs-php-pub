<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class SearchResult
{
    public function __construct(
        public string $type,
        public string $frameworkSlug,
        public string $frameworkName,
        public ?int $articleNumber,
        public ?int $recitalNumber,
        public ?string $paragraphRef,
        public ?string $title,
        public ?string $requirementType,
        public string $matchContext,
        public string $url,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $fw = is_array($data['framework'] ?? null) ? $data['framework'] : [];

        return new self(
            type:            (string) ($data['type'] ?? ''),
            frameworkSlug:   (string) ($data['framework_slug'] ?? $fw['slug'] ?? ''),
            frameworkName:   (string) ($data['framework_name'] ?? $fw['name'] ?? ''),
            articleNumber:   isset($data['article_number']) ? (int) $data['article_number'] : null,
            recitalNumber:   isset($data['recital_number']) ? (int) $data['recital_number'] : null,
            paragraphRef:    isset($data['paragraph_ref']) ? (string) $data['paragraph_ref'] : null,
            title:           isset($data['title']) ? (string) $data['title'] : null,
            requirementType: isset($data['requirement_type']) ? (string) $data['requirement_type'] : null,
            matchContext:    (string) ($data['match_context'] ?? ''),
            url:             (string) ($data['url'] ?? ''),
        );
    }
}
