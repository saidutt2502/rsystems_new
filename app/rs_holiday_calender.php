<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_holiday_calender extends Model
{
protected $table = 'rs_holiday_calender';
protected $guarded = [];
use SoftDeletes;
}
?>