<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Step extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->uuid = Uuid::uuid4();
            $model->creator_id = request()?->user()?->id;
            $model->tenant_id = request()?->user()?->tenant_id;

            if ($model->is_current) {
                DB::table("steps")->whereVacancyId($model->vacancy_id)->update(['is_current' => 0]);
            }
        });

        static::updating(function (Model $model) {
            if ($model->is_current) {
                DB::table("steps")->whereVacancyId($model->vacancy_id)->where('id', '!=', $model->id)->update(['is_current' => 0]);
            }
        });
    }
}
