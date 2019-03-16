<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_airports extends Model
{
protected $table = 'rs_taxi_airports';
protected $guarded = [];
use SoftDeletes;
}
?>