<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;
use Ramsey\Uuid\Uuid;

class Vacancy extends Model
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

    public function applies () {
        return $this->hasMany(Apply::class);
    }

    public function steps () {
        return $this->hasMany(Step::class);
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

    public function skills () {
        return $this->hasMany(VacancySkill::class);
    }

    public function languages () {
        return $this->hasMany(VacancyLanguage::class);
    }


}
