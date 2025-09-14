<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DBLogger
{
    public static function insert(string $table, array $data)
    {
        $result = DB::table($table)->insert($data);

        self::writeLog($table, null, 'created', [
            'after' => self::safeArray($data),
        ]);

        return $result;
    }

    public static function update(string $table, array $where, array $data)
    {
        $before = DB::table($table)->where($where)->first();
        if (!$before) {
            return 0; // tidak ada row yang match
        }

        $result = DB::table($table)->where($where)->update($data);

        $after = DB::table($table)->where($where)->first();

        $changes = [];
        foreach ($data as $key => $new) {
            $old = data_get($before, $key);
            if ($old != $new) {
                $changes[$key] = [
                    'from' => $old,
                    'to'   => $new,
                ];
            }
        }

        if (!empty($changes)) {
            $modelId = $before->id ?? json_encode($where);

            self::writeLog($table, $modelId, 'updated', [
                'changes' => $changes,
            ]);
        }

        return $result;
    }

    public static function softDelete(string $table, array $where)
    {
        $before = DB::table($table)->where($where)->first();
        if (!$before) {
            return 0;
        }

        $result = DB::table($table)->where($where)->update(['deleted_at' => now()]);

        self::writeLog($table, $before->id ?? null, 'deleted', [
            'before' => self::safeArray((array) $before),
        ]);

        return $result;
    }

    protected static function writeLog(string $table, $modelId, string $action, array $payload = []): void
    {
        $userId = Auth::check() ? Auth::id() : null;

        $data = [
            'table'      => $table,
            'model'      => '', // tidak ada model class
            'model_id'   => (string) $modelId,
            'action'     => $action,
            'user_id'    => $userId,
            'changes'    => $payload['changes'] ?? null,
            'before'     => $payload['before'] ?? null,
            'after'      => $payload['after'] ?? null,
            'ip'         => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'url'        => request()?->fullUrl(),
            'method'     => request()?->method(),
            'batch_id'   => self::batchId(),
            'created_at' => now(),
            'updated_at' => now(),
            'RecordOwnerID' => Auth::user()->RecordOwnerID
        ];

        DB::afterCommit(function () use ($data) {
            ActivityLog::query()->create($data);
        });
    }

    protected static function safeArray(array $data): array
    {
        $exclude = ['password', 'remember_token', 'updated_at'];
        return collect($data)->except($exclude)->all();
    }

    protected static function batchId(): string
    {
        static $id;
        if (!$id) $id = (string) Str::uuid();
        return $id;
    }
}
