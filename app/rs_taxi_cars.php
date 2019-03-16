<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_cars extends Model
{
protected $table = 'rs_taxi_cars';
protected $guarded = [];
use SoftDeletes;
}
?>