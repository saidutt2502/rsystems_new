<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_items extends Model
{
protected $table = 'rs_items';
protected $guarded = [];
use SoftDeletes;
}
?>