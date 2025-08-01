<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Onboarding
{
    public function handle(Request $request, Closure $next)
    {
        // Skip if user is not authenticated
        if (! Auth::check()) {
            return $next($request);
        }
        
        // Enhanced Livewire and AJAX detection
        if ($this->isLivewireOrAjaxRequest($request)) {
            return $next($request);
        }
        
        // Skip Livewire routes
        if ($request->routeIs('livewire.*') || str_starts_with($request->path(), 'livewire/')) {
            return $next($request);
        }
        
        $user = Auth::user();
        
        if (!$user->isComplete()) {
            if (! $request->routeIs([
                'onboarding.step-1',
                'logout',
            ])) {
                return redirect()->route('onboarding.step-1');
            }
        }
        
        if (!$user->hasStore()) {
            if (! $request->routeIs([
                'onboarding.step-2',
                'logout',
            ])) {
                return redirect()->route('onboarding.step-2');
            }
        }
        
        
        $routeName = $request->route()->getName();
        if (($user->isComplete() && 'onboarding.step-1' === $routeName)
        || ($user->hasStore() && 'onboarding.step-2' === $routeName)) {
            return redirect()->route('dashboard');
        }
        
        return $next($request);
    }
    
    /**
     * Check if the request is from Livewire or AJAX
     */
    private function isLivewireOrAjaxRequest(Request $request): bool
    {
        return $request->expectsJson()
            || $request->isXmlHttpRequest()
            || $request->header('X-Livewire')
            || $request->header('X-Requested-With') === 'XMLHttpRequest'
            || $request->hasHeader('X-Livewire-Request')
            || $request->wantsJson()
            || str_contains($request->header('Accept', ''), 'application/json');
    }
}