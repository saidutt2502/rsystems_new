<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_tms_users2dept extends Model
{
protected $table = 'rs_tms_users2dept';
protected $guarded = [];
use SoftDeletes;
}
?>