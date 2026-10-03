<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditAdminActions
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $response = $next($request);

        if ($user && $request->is('admin/*')) {

            // Don't create a log while viewing the audit log itself.
            if ($request->is('admin/audit-logs')) {
                return $response;
            }

            $action = match ($request->method()) {
                'GET' => 'VIEW',
                'POST' => 'CREATE',
                'PUT', 'PATCH' => 'UPDATE',
                'DELETE' => 'DELETE',
                default => $request->method(),
            };

            $routeName = $request->route()?->getName();

            $description = $routeName
                ? "Admin performed {$action} on {$routeName}"
                : "Admin performed {$action} on {$request->path()}";

            AuditLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'description' => $description,
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }
}