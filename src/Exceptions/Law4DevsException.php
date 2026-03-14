<?php

declare(strict_types=1);

namespace Law4Devs\Exceptions;

use RuntimeException;

class Law4DevsException extends RuntimeException
{
    public function __construct(
        string $message = '',
        public readonly ?int $statusCode = null,
    ) {
        parent::__construct($message);
    }
}
