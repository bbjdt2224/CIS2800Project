<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timesheet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'userId', 'startDate', 'status', 'total', 'signature', 'adminSignature', 'notes'
    ];

    protected $dates = ['deleted_at'];

    public function shift(){
        return $this->hasMany('App\Shift');
    }

    public function users() {
        return $this.belongsTo('App\User');
    }
}
