<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_admin2modules extends Model
{
protected $table = 'rs_admin2modules';
protected $guarded = [];
use SoftDeletes;
}
?>