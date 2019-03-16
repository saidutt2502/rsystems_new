<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_production_chart extends Model
{
protected $table = 'rs_production_chart';
protected $guarded = [];
use SoftDeletes;
}
?>