<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class RedirectController extends Controller
{
    public function handle(Request $request, string $code)
    {
        $link = Link::where('short_code', $code)->firstOrFail();

        if (!$link->is_active) {
            return response()->view('errors.link-inactive', ['link' => $link], 404);
        }

        if ($link->isExpired()) {
            return response()->view('errors.link-expired', ['link' => $link], 410);
        }

        // تسجيل النقرة
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        LinkClick::create([
            'link_id'    => $link->id,
            'ip'         => $request->ip(),
            'country'    => $this->getCountry($request->ip()),
            'device'     => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser'    => $agent->browser(),
            'referer'    => $request->header('referer'),
            'clicked_at' => now(),
        ]);

        return redirect()->away($link->original_url);
    }

    private function getCountry(string $ip): ?string
    {
        // بسيطة بدون API خارجي
        try {
            $data = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country");
            return json_decode($data)?->country;
        } catch (\Exception $e) {
            return null;
        }
    }
}
