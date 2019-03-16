<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class rs_company_production extends Model
{
protected $table = 'rs_company_production';
protected $guarded = [];
use SoftDeletes;
}
?>