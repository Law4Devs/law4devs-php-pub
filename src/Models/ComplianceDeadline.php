<?php

declare(strict_types=1);

namespace Law4Devs\Models;

final readonly class ComplianceDeadline
{
    public function __construct(
        public int $id,
        public string $frameworkSlug,
        public ?string $articleNumber,
        public ?string $paragraphRef,
        public string $deadlineDate,
        public string $deadlineType,
        public ?string $description,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $fw = is_array($data['framework'] ?? null) ? $data['framework'] : [];

        return new self(
            id:            (int) $data['id'],
            frameworkSlug: (string) ($data['framework_slug'] ?? $fw['slug'] ?? ''),
            articleNumber: isset($data['article_number']) ? (string) $data['article_number'] : null,
            paragraphRef:  isset($data['paragraph_ref']) ? (string) $data['paragraph_ref'] : null,
            deadlineDate:  (string) ($data['deadline_date'] ?? ''),
            deadlineType:  (string) ($data['deadline_type'] ?? ''),
            description:   isset($data['description']) ? (string) $data['description'] : null,
        );
    }
}
