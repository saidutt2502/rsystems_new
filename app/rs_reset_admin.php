<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_reset_admin extends Model
{
protected $table = 'rs_reset_admin';
protected $guarded = [];
use SoftDeletes;
}
?>