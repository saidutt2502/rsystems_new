<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_location2department extends Model
{
protected $table = 'rs_location2department';
protected $guarded = [];
use SoftDeletes;
}
?>