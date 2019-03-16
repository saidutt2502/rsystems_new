<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_requests extends Model
{
protected $table = 'rs_taxi_requests';
protected $guarded = [];
use SoftDeletes;
}
?>