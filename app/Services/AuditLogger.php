<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditLogger
{
    public static function log(
        string $action,
        ?string $description = null
    ): void {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}