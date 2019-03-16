<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_reporting extends Model
{
protected $table = 'rs_reporting';
protected $guarded = [];
use SoftDeletes;
}
?>