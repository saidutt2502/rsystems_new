<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_stationaryrequests extends Model
{
protected $table = 'rs_stationaryrequests';
protected $guarded = [];
use SoftDeletes;
}
?>