<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_costcenters extends Model
{
protected $table = 'rs_costcenters';
protected $guarded = [];
use SoftDeletes;
}
?>