<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_workstations extends Model
{
protected $table = 'rs_tms_workstations';
protected $guarded = [];
use SoftDeletes;
}
?>