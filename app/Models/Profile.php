<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;
use Ramsey\Uuid\Uuid;

class Profile extends Model
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

        static::addGlobalScope('tenant', function ($query) {
            if (in_array(request()->user()->type, ['admin', 'manager'])) $query->whereTenantId(request()?->user()?->tenant_id);
            else $query->whereUserId(request()?->user()?->id);
        });
    }

    public function skills () {
        return $this->hasMany(ProfileSkill::class);
    }

    public function languages () {
        return $this->hasMany(ProfileLanguage::class);
    }

    public function experiences () {
        return $this->hasMany(Experience::class);
    }

    public function academics () {
        return $this->hasMany(Academic::class);
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

    public function user() {
        return $this->belongsTo(User::class);
    }

}
