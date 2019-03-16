<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_taxisettings extends Model
{
protected $table = 'rs_taxisettings';
protected $guarded = [];
use SoftDeletes;
}
?>