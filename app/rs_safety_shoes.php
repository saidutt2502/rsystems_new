<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_safety_shoes extends Model
{
protected $table = 'rs_safety_shoes';
protected $guarded = [];
use SoftDeletes;
}
?>