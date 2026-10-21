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
        if ($response->getStatusCode() !== 200) {
            return;
        }

        try {
            $this->analytics->record($request);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
