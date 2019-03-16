<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_type extends Model
{
protected $table = 'rs_taxi_type';
protected $guarded = [];
use SoftDeletes;
}
?>