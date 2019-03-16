<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_products extends Model
{
protected $table = 'rs_tms_products';
protected $guarded = [];
use SoftDeletes;
}
?>