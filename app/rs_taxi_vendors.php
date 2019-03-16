<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxi_vendors extends Model
{
protected $table = 'rs_taxi_vendors';
protected $guarded = [];
use SoftDeletes;
}
?>