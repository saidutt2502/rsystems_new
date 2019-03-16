<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class users_type extends Model
{
protected $table = 'users_type';
protected $guarded = [];
use SoftDeletes;
}
?>