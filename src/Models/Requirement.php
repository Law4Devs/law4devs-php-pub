<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class Requirement
{
    /**
     * @param int[]    $linkedArticleNumbers
     * @param string[] $stakeholderRoles
     * @param Tag[]    $tags
     */
    public function __construct(
        public int $id,
        public string $frameworkSlug,
        public ?int $articleNumber,
        public ?string $paragraphRef,
        public ?string $paragraphContent,
        public string $requirementText,
        public string $requirementType,
        public ?string $complianceDeadline,
        public array $linkedArticleNumbers,
        public array $stakeholderRoles,
        public array $tags,
        public string $createdAt,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $fw = is_array($data['framework'] ?? null) ? $data['framework'] : [];

        return new self(
            id:                   (int) $data['id'],
            frameworkSlug:        (string) ($data['framework_slug'] ?? $fw['slug'] ?? ''),
            articleNumber:        isset($data['article_number']) ? (int) $data['article_number'] : null,
            paragraphRef:         isset($data['paragraph_ref']) ? (string) $data['paragraph_ref'] : null,
            paragraphContent:     isset($data['paragraph_content']) ? (string) $data['paragraph_content'] : null,
            requirementText:      (string) ($data['requirement_text'] ?? ''),
            requirementType:      (string) ($data['requirement_type'] ?? 'general'),
            complianceDeadline:   isset($data['compliance_deadline']) ? (string) $data['compliance_deadline'] : null,
            linkedArticleNumbers: array_map('intval', (array) ($data['linked_article_numbers'] ?? [])),
            stakeholderRoles:     array_map('strval', (array) ($data['stakeholder_roles'] ?? [])),
            tags:                 array_map(
                fn($t) => is_array($t) ? Tag::fromArray($t) : $t,
                (array) ($data['tags'] ?? []),
            ),
            createdAt: (string) ($data['created_at'] ?? ''),
        );
    }
}
