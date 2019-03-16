<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_gp_settings extends Model
{
protected $table = 'rs_gp_settings';
protected $guarded = [];
use SoftDeletes;
}
?>