<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_safety_requests extends Model
{
protected $table = 'rs_safety_requests';
protected $guarded = [];
use SoftDeletes;
}
?>