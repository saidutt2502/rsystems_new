<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_production_dept extends Model
{
protected $table = 'rs_production_dept';
protected $guarded = [];
use SoftDeletes;
}
?>