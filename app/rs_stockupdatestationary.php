<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_stockupdatestationary extends Model
{
protected $table = 'rs_stockupdatestationary';
protected $guarded = [];
use SoftDeletes;
}
?>