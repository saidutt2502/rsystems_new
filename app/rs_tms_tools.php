<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_tools extends Model
{
protected $table = 'rs_tms_tools';
protected $guarded = [];
use SoftDeletes;
}
?>