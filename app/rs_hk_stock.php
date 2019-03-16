<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_hk_stock extends Model
{
protected $table = 'rs_hk_stock';
protected $guarded = [];
use SoftDeletes;
}
?>