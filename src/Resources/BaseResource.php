<?php

declare(strict_types=1);

namespace Law4Devs\Resources;

use Law4Devs\HttpClient;
use Law4Devs\Pagination\Page;
use Law4Devs\Pagination\PageLinks;
use Law4Devs\Pagination\PageMeta;

abstract class BaseResource
{
    public function __construct(
        protected readonly HttpClient $http,
    ) {}

    /** @return array<string, mixed> */
    protected function pageParams(?int $page, ?int $perPage): array
    {
        $params = [];
        if ($page !== null) {
            $params['page'] = $page;
        }
        if ($perPage !== null) {
            $params['per_page'] = $perPage;
        }
        return $params;
    }

    /**
     * @template T
     * @param callable(array<string, mixed>): T $factory
     * @param array<string, mixed> $raw
     * @return Page<T>
     */
    protected function parsePage(array $raw, callable $factory): Page
    {
        $meta  = PageMeta::fromArray((array) ($raw['meta'] ?? []));
        $links = PageLinks::fromArray((array) ($raw['links'] ?? []));
        $data  = array_map($factory, (array) ($raw['data'] ?? []));

        return new Page($data, $meta, $links);
    }

    /**
     * Auto-paginate: yields individual items across all pages.
     *
     * @template T
     * @param callable $listFn  The resource list() method
     * @param mixed    ...$args Arguments forwarded to $listFn (excluding page/perPage)
     * @return \Generator<int, T>
     */
    protected function iterPages(callable $listFn, mixed ...$args): \Generator
    {
        $page    = 1;
        $perPage = 20;

        while (true) {
            /** @var Page<T> $result */
            $result = $listFn(...$args, page: $page, perPage: $perPage);
            yield from $result->data;

            if ($result->links->next === null) {
                break;
            }
            $page++;
        }
    }
}
