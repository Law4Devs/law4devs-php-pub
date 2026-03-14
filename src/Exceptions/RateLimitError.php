<?php

declare(strict_types=1);

namespace Law4Devs\Exceptions;

/** Raised when the rate limit is exceeded (429). */
class RateLimitError extends Law4DevsException {}
