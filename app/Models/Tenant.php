<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Ramsey\Uuid\Uuid;

class Tenant extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    #[Override]
    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->uuid = Uuid::uuid4();
            $model->creator_id = request()?->user()?->id;
        });
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }
}
