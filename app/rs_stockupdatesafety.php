<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_stockupdatesafety extends Model
{
protected $table = 'rs_stockupdatesafety';
protected $guarded = [];
use SoftDeletes;
}
?>