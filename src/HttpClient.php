<?php

declare(strict_types=1);

namespace Law4Devs;

use Law4Devs\Exceptions\Law4DevsException;
use Law4Devs\Exceptions\NotFoundError;
use Law4Devs\Exceptions\RateLimitError;
use Law4Devs\Exceptions\ServerError;
use Law4Devs\Exceptions\ValidationError;

final class HttpClient
{
    public const DEFAULT_BASE_URL = 'https://api.law4devs.eu/v1';

    private readonly array $headers;

    public function __construct(
        private readonly string $baseUrl = self::DEFAULT_BASE_URL,
        private readonly string $apiKey = '',
        private readonly int $timeout = 30,
        private readonly int $maxRetries = 3,
    ) {
        $headers = [
            'Accept: application/json',
            'User-Agent: law4devs-php/' . Version::VERSION,
        ];

        if ($apiKey !== '') {
            $headers[] = 'X-API-Key: ' . $apiKey;
        }

        $this->headers = $headers;
    }

    /**
     * Make a GET request with automatic retry on 429/5xx.
     *
     * @return array<string, mixed>
     * @throws Law4DevsException
     */
    public function get(string $path, array $params = []): array
    {
        $url = rtrim($this->baseUrl, '/') . $path;

        if ($params !== []) {
            $clean = array_filter(
                array_map(fn($v) => $v !== null ? (string) $v : null, $params),
                fn($v) => $v !== null,
            );
            if ($clean !== []) {
                $url .= '?' . http_build_query($clean);
            }
        }

        $lastException = null;

        for ($attempt = 0; $attempt < $this->maxRetries; $attempt++) {
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => $this->headers,
                CURLOPT_TIMEOUT        => $this->timeout,
                CURLOPT_FOLLOWLOCATION => true,
            ]);

            $body     = curl_exec($ch);
            $status   = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlErr  = curl_error($ch);
            curl_close($ch);

            if ($body === false || $curlErr !== '') {
                $lastException = new Law4DevsException('Request failed: ' . $curlErr);
                if ($attempt < $this->maxRetries - 1) {
                    sleep(2 ** $attempt);
                    continue;
                }
                throw $lastException;
            }

            $data = json_decode((string) $body, true);

            if ($status >= 200 && $status < 300) {
                return is_array($data) ? $data : [];
            }

            $message = (string) ($data['error']['message'] ?? "HTTP {$status}");

            if ($status === 404) {
                throw new NotFoundError($message, $status);
            }

            if ($status === 400) {
                throw new ValidationError($message, $status);
            }

            if ($status === 429) {
                if ($attempt < $this->maxRetries - 1) {
                    sleep(2 ** $attempt);
                    $lastException = new RateLimitError($message, $status);
                    continue;
                }
                throw new RateLimitError($message, $status);
            }

            if ($status >= 500) {
                if ($attempt < $this->maxRetries - 1) {
                    sleep(2 ** $attempt);
                    $lastException = new ServerError($message, $status);
                    continue;
                }
                throw new ServerError($message, $status);
            }

            throw new Law4DevsException($message, $status);
        }

        throw $lastException ?? new Law4DevsException('Max retries exceeded');
    }
}
