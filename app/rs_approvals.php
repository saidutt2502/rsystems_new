<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_approvals extends Model
{
protected $table = 'rs_approvals';
protected $guarded = [];
use SoftDeletes;
}
?>