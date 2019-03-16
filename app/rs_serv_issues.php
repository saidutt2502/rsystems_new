<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_serv_issues extends Model
{
protected $table = 'rs_serv_issues';
protected $guarded = [];
use SoftDeletes;
}
?>