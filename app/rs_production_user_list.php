<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_production_user_list extends Model
{
protected $table = 'rs_production_user_list';
protected $guarded = [];
use SoftDeletes;
}
?>