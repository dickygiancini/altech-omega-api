<?php

namespace App\Http\Middleware;

use App\Models\Address;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressExistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');

        if(!Address::find($id)) {
            return response()->json(['status' => 404, 'message' => 'Address not found'], 404);
        }
        return $next($request);
    }
}
