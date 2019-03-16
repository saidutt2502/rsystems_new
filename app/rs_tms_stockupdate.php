<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_stockupdate extends Model
{
protected $table = 'rs_tms_stockupdate';
protected $guarded = [];
use SoftDeletes;
}
?>