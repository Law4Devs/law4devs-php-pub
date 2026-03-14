# Changelog

## 1.0.0 — 2026-03-14

- Updated API base URL path from `/api/v1` to `/v1`

## 0.1.0 — 2025-01-01

Initial release.

- Full PHP 8.1+ SDK for the Law4Devs EU Regulatory Compliance API
- Resources: frameworks, articles, recitals, requirements, tags, compliance, annexes, search
- Auto-pagination via `\Generator` (`iter()` methods)
- Automatic retry on 429/5xx with exponential backoff
- Zero dependencies — cURL + JSON extensions only
