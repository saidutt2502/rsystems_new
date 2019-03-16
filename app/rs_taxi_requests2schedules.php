<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_requests2schedules extends Model
{
protected $table = 'rs_taxi_requests2schedules';
protected $guarded = [];
use SoftDeletes;
}
?>