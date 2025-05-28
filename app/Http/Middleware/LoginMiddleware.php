<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Hash;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('email', $request->email)->first();

        if(!$user) {
                $log = new ModelsLog();
                $log->note = "You tried to logged in";
                $log->action = "login";
                $log->status = "error";
                $log->save();
            return response()->json(['message'=>'failed']);
        }
        else {
            if(Hash::check($request->password, $user->password)){
                                $log = new ModelsLog();
                $log->note = "You tried to logged in";
                $log->action = "login";
                $log->status = "successful";
                $log->save();
                $request->session()->put('authenticated', true);
                return $next($request);
            }
        }

        return response()->json(['message'=>'failed']);
    }
}
