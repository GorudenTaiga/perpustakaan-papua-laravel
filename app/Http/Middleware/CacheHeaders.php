<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only cache successful GET responses
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $path = $request->path();

            // Public book listing & category pages: 5 min browser + 1 hr CDN cache
            if (in_array($path, ['buku', 'categories']) || str_starts_with($path, 'buku/')) {
                $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=3600, stale-while-revalidate=60');
            }

            // Homepage: 2 min browser + 10 min CDN
            if ($path === '/' || $path === '') {
                $response->headers->set('Cache-Control', 'public, max-age=120, s-maxage=600, stale-while-revalidate=60');
            }
        }

        return $response;
    }
}
