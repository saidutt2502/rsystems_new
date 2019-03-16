<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_location2users extends Model
{
protected $table = 'rs_location2users';
protected $guarded = [];
use SoftDeletes;
}
?>