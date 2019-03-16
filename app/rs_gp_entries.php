<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_gp_entries extends Model
{
protected $table = 'rs_gp_entries';
protected $guarded = [];
use SoftDeletes;
}
?>