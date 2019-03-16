<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_modules_programmer extends Model
{
protected $table = 'rs_modules_programmer';
protected $guarded = [];
use SoftDeletes;
}
?>