<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (Auth::check()) {
            // Kiểm tra nếu quyền của người dùng có trong danh sách các quyền
            if (in_array(Auth::user()->quyen, $roles)) {
                return $next($request);
            }
        }

        // Nếu không có quyền, chuyển hướng về trang không đủ quyền
        return redirect()->route('notify')->with('error', 'Bạn không đủ quyền truy cập vào trang web này.');
    }
}
