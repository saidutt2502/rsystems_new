<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_hkrequests extends Model
{
protected $table = 'rs_hkrequests';
protected $guarded = [];
use SoftDeletes;
}
?>