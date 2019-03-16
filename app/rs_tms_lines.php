<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_lines extends Model
{
protected $table = 'rs_tms_lines';
protected $guarded = [];
use SoftDeletes;
}
?>