<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_locations extends Model
{
protected $table = 'rs_locations';
protected $guarded = [];
use SoftDeletes;
}
?>