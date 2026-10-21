<?php

namespace App\Http\Middleware;

use App\Support\StoreAnalytics;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RecordStoreVisit
{
    public function __construct(private StoreAnalytics $analytics) {}

    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! $this->shouldRecord($request, $response)) {
            return;
        }

        try {
            $this->analytics->record($request);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private function shouldRecord(Request $request, Response $response): bool
    {
        if (! $request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson() || $request->prefetch()) {
            return false;
        }

        if ($request->is('admin', 'admin/*', 'livewire', 'livewire/*', 'up', 'search/suggest', 'products/*/quick-view')) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');

        if (! str_contains($contentType, 'text/html')) {
            return false;
        }

        $agent = (string) $request->userAgent();

        return $agent !== '' && preg_match('/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|telegrambot|preview|headless/i', $agent) !== 1;
    }
}
