<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Header keamanan HTTP untuk semua halaman web.
 *
 * CSP & HSTS hanya aktif di produksi: saat pengembangan, Vite dev server
 * (http://localhost:5173) memuat skrip dari origin lain yang akan diblokir CSP.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $headers = $response->headers;

        // Cegah browser "menebak" tipe file (mis. file upload dibaca sebagai HTML/JS).
        $headers->set('X-Content-Type-Options', 'nosniff');
        // Cegah situs lain menyematkan website ini dalam iframe (clickjacking).
        $headers->set('X-Frame-Options', 'DENY');
        $headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');
        $headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // Jangan umumkan versi PHP ke pengunjung.
        $headers->remove('X-Powered-By');
        if (! headers_sent()) {
            header_remove('X-Powered-By');
        }

        if (app()->isProduction()) {
            $headers->set('Content-Security-Policy', $this->contentSecurityPolicy($request));

            if ($request->isSecure()) {
                $headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            }
        }

        return $response;
    }

    /**
     * 'unsafe-inline' masih diperlukan karena ada <script> inline dan atribut
     * onerror/onsubmit di view. Sumber eksternal hanya Google Fonts.
     */
    private function contentSecurityPolicy(Request $request): string
    {
        $aturan = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: blob:",
            "connect-src 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "object-src 'none'",
        ];

        if ($request->isSecure()) {
            $aturan[] = 'upgrade-insecure-requests';
        }

        return implode('; ', $aturan);
    }
}
