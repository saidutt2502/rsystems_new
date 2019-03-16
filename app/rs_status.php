<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_status extends Model
{
protected $table = 'rs_status';
protected $guarded = [];
use SoftDeletes;
}
?>