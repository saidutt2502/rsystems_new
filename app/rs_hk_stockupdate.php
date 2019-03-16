<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_hk_stockupdate extends Model
{
protected $table = 'rs_hk_stockupdate';
protected $guarded = [];
use SoftDeletes;
}
?>