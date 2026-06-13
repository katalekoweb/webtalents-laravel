<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;
use Ramsey\Uuid\Uuid;

class VacancyLanguage extends Model
{
    protected $guarded = [];

    #[Override]
    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->uuid = Uuid::uuid4();
            $model->creator_id = request()?->user()?->id;
            $model->tenant_id = request()?->user()?->tenant_id;
        });
    }
}
