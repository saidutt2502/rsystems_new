<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_users_production extends Model
{
protected $table = 'rs_users_production';
protected $guarded = [];
use SoftDeletes;
}
?>