<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreReferral
{
    public function handle(Request $request, Closure $next): Response
    {
        $ref = $request->query('ref');
        $utmSource = $request->query('utm_source');
        $utmMedium = $request->query('utm_medium');
        $utmCampaign = $request->query('utm_campaign');

        // Persist in session
        if ($ref) session(['ref_code' => $ref]);
        if ($utmSource) session(['utm_source' => $utmSource]);
        if ($utmMedium) session(['utm_medium' => $utmMedium]);
        if ($utmCampaign) session(['utm_campaign' => $utmCampaign]);

        // Also persist cookies for ~30 days
        $response = $next($request);
        $minutes = 60 * 24 * 30; // 30 days
        if ($ref) $response->headers->setCookie(cookie('ref_code', $ref, $minutes));
        if ($utmSource) $response->headers->setCookie(cookie('utm_source', $utmSource, $minutes));
        if ($utmMedium) $response->headers->setCookie(cookie('utm_medium', $utmMedium, $minutes));
        if ($utmCampaign) $response->headers->setCookie(cookie('utm_campaign', $utmCampaign, $minutes));

        // Log a referral visit only once per session
        if ($ref && !session()->has('ref_logged')) {
            $refUser = User::where('affiliate_code', $ref)->first();
            try {
                DB::table('referrals')->insert([
                    'ref_code' => $ref,
                    'ref_user_id' => optional($refUser)->id,
                    'utm_source' => $utmSource,
                    'utm_medium' => $utmMedium,
                    'utm_campaign' => $utmCampaign,
                    'ip' => $request->ip(),
                    'user_agent' => substr((string) $request->userAgent(), 0, 255),
                    'landing_path' => substr($request->getRequestUri(), 0, 255),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                session(['ref_logged' => true]);
            } catch (\Throwable $e) {
                // swallow errors to never break user flow
            }
        }

        return $response;
    }
}
