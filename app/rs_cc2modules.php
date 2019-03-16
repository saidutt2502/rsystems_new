<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_cc2modules extends Model
{
protected $table = 'rs_cc2modules';
protected $guarded = [];
use SoftDeletes;
}
?>