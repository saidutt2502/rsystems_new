<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_departments extends Model
{
protected $table = 'rs_tms_departments';
protected $guarded = [];
use SoftDeletes;
}
?>