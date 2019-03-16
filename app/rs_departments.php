<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_departments extends Model
{
protected $table = 'rs_departments';
protected $guarded = [];
use SoftDeletes;
}
?>