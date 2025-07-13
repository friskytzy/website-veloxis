<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class SpamProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rate limiting for contact forms
        if ($request->is('contact/store')) {
            $key = 'contact_form_' . $request->ip();
            
            if (RateLimiter::tooManyAttempts($key, 3)) {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 jam.'
                ], 429);
            }
            
            RateLimiter::hit($key, 3600); // 1 hour decay
        }

        // Check for honeypot field
        if ($request->has('honeypot') && !empty($request->input('honeypot'))) {
            return response()->json([
                'message' => 'Akses ditolak.'
            ], 403);
        }

        // Check for suspicious patterns in contact form
        if ($request->is('contact/store')) {
            $message = $request->input('message', '');
            $name = $request->input('name', '');
            $email = $request->input('email', '');
            
            // Check for suspicious keywords
            $suspiciousKeywords = [
                'buy', 'sell', 'loan', 'credit', 'casino', 'viagra', 'cialis',
                'make money', 'earn money', 'work from home', 'get rich'
            ];
            
            foreach ($suspiciousKeywords as $keyword) {
                if (stripos($message, $keyword) !== false || 
                    stripos($name, $keyword) !== false || 
                    stripos($email, $keyword) !== false) {
                    return response()->json([
                        'message' => 'Pesan mengandung konten yang tidak diizinkan.'
                    ], 403);
                }
            }
            
            // Check for excessive links
            if (substr_count($message, 'http') > 3) {
                return response()->json([
                    'message' => 'Pesan mengandung terlalu banyak link.'
                ], 403);
            }
            
            // Check for suspicious email patterns
            if (preg_match('/\b(mr\.|mrs\.|dr\.|prof\.)\b/i', $name)) {
                return response()->json([
                    'message' => 'Format nama tidak valid.'
                ], 403);
            }
        }

        return $next($request);
    }
}
