<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        // CREATE
        static::created(function ($model) {
            self::writeLog($model, 'created', [
                'after' => self::safeArray($model->toArray(), $model),
            ]);
        });

        // UPDATE (hanya field bermakna)
        static::updated(function ($model) {
            $exclude = array_merge(self::defaultExcluded(), $model->activityLogIgnore ?? []);
            $dirty = collect($model->getChanges())->except($exclude);

            if ($dirty->isEmpty()) {
                return; // tidak ada perubahan penting
            }

            $changes = [];
            foreach ($dirty as $key => $new) {
                $changes[$key] = [
                    'from' => data_get($model->getOriginal(), $key),
                    'to'   => $new,
                ];
            }

            self::writeLog($model, 'updated', ['changes' => $changes]);
        });

        // DELETE (soft/hard)
        static::deleted(function ($model) {
            $action = (method_exists($model, 'isForceDeleting') && $model->isForceDeleting())
                ? 'force_deleted'
                : 'deleted';

            self::writeLog($model, $action, [
                'before' => self::safeArray($model->toArray(), $model),
            ]);
        });

        // RESTORE (kalau pakai SoftDeletes)
        if (method_exists(static::class, 'restore')) {
            static::restored(function ($model) {
                self::writeLog($model, 'restored', [
                    'after' => self::safeArray($model->toArray(), $model),
                ]);
            });
        }
    }

    protected static function writeLog($model, string $action, array $payload = []): void
    {
        // Global/model-level toggle
        // if (function_exists('config') && config('activitylog.enabled') === false) return;
        // if (defined('static::DISABLE_ACTIVITY_LOG') && static::DISABLE_ACTIVITY_LOG) return;
        // if (property_exists($model, 'disableActivityLog') && $model->disableActivityLog) return;

        $userId = auth()->check() ? auth()->id() : null;
        $RecordOwnerID = auth()->check() && auth()->user() ? auth()->user()->RecordOwnerID : null;

        $data = [
            'table'      => $model->getTable(),
            'model'      => get_class($model),
            'model_id'   => (string) $model->getKey(),
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
            'RecordOwnerID' => $RecordOwnerID
        ];

        // Tulis log HANYA setelah transaksi berhasil commit
        DB::afterCommit(function () use ($data) {
            ActivityLog::query()->create($data);
        });
    }

    protected static function safeArray(array $data, $model): array
    {
        $exclude = array_merge(self::defaultExcluded(), $model->activityLogIgnore ?? []);
        return collect($data)->except($exclude)->all();
    }

    protected static function defaultExcluded(): array
    {
        return ['password', 'remember_token', 'updated_at'];
    }

    protected static function batchId(): string
    {
        static $id;
        if (!$id) $id = (string) Str::uuid();
        return $id;
    }
}
