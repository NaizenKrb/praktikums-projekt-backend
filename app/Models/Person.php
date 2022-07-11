<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "firstName",
        "lastName",
        "birthDate",
        "department",
        "maxAmountOfHolidays"
    ];
    protected $dates = [
        "birthDate"
    ];
    protected $casts = [
        "birthDate" => "date:Y-m-d",
    ];

    public function holidays()
    {
        return $this->hasMany(PersonHoliday::class);
    }

}