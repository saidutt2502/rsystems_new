<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_schedules extends Model
{
protected $table = 'rs_taxi_schedules';
protected $guarded = [];
use SoftDeletes;
}
?>