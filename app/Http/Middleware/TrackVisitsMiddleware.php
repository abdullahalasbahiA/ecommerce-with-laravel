<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Step 1: Generate a unique hash for the visitor (IP + User Agent)
        $visitorHash = Hash::make($request->ip() . $request->userAgent());

        // Step 2: Find or create the unique visitor
        $visitor = Visitor::firstOrCreate(
            ['visitor_hash' => $visitorHash],
            [
                'ip' => $request->ip(),
                'country' => $this->getCountryFromIP($request->ip()) // See Step 3
            ]
        );

        // Step 3: Log EVERY visit (total visits)
        Visit::create([
            'visitor_id' => $visitor->id,
            'page_url' => $request->path()
        ]);

        return $next($request);
    }

    // Helper method to get country from IP (Step 3)
    private function getCountryFromIP($ip)
    {
        if ($ip === '127.0.0.1') return 'Localhost'; // Skip for local dev
        return json_decode(file_get_contents("http://ip-api.com/json/{$ip}"))->country ?? 'Unknown';
    }
}
