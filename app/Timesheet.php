<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'userId', 'startDate', 'submitted', 'total',
    ];

    protected $dates = ['deleted_at'];

    public function shift(){
        return $this->hasMany('App\Shift');
    }
}
