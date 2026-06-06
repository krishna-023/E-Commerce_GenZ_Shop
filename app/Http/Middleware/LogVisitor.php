<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\VisitorAction;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\View;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();

        // 1️⃣ Track visitor by IP
        $visitor = Visitor::firstOrCreate(
            ['ip' => $request->ip()],
            [
                'user_agent' => $request->userAgent(),
                'device' => $agent->device(),
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
            ]
        );

        // 2️⃣ Track visitor action
        $action = $request->method() . ' ' . $request->path();
        $visitorAction = VisitorAction::create([
            'visitor_id' => $visitor->id,
            'action' => $action,
            'url' => $request->fullUrl(),
            'referer' => $request->headers->get('referer') ?? null,
        ]);

        // 3️⃣ Share $track with all views
        $track = (object)[
            'visitor_id' => $visitor->id,
            'action' => $action,
            'url' => $request->fullUrl(),
            'time' => now()->toDateTimeString(),
        ];

        View::share('track', $track);

        return $next($request);
    }
}
