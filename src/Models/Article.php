<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class Article
{
    /**
     * @param Tag[]              $tags
     * @param ArticleParagraph[] $paragraphs
     */
    public function __construct(
        public int $id,
        public string $frameworkSlug,
        public int $articleNumber,
        public string $title,
        public int $position,
        public int $paragraphCount,
        public array $tags,
        public string $content,
        public array $paragraphs,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $fw = is_array($data['framework'] ?? null) ? $data['framework'] : [];

        return new self(
            id:             (int) $data['id'],
            frameworkSlug:  (string) ($data['framework_slug'] ?? $fw['slug'] ?? ''),
            articleNumber:  (int) ($data['article_number'] ?? 0),
            title:          (string) ($data['title'] ?? ''),
            position:       (int) ($data['position'] ?? 0),
            paragraphCount: (int) ($data['paragraph_count'] ?? 0),
            tags:           array_map(
                fn($t) => is_array($t) ? Tag::fromArray($t) : $t,
                (array) ($data['tags'] ?? []),
            ),
            content:    (string) ($data['content'] ?? ''),
            paragraphs: array_map(
                fn($p) => ArticleParagraph::fromArray($p),
                (array) ($data['paragraphs'] ?? []),
            ),
        );
    }
}
