@extends('layouts.user-master')


@section('css-files')
    <link rel="stylesheet" href="/core/css/bootstrap-duallistbox.min.css" />
@endsection



@section('breadcrumb')
    <li class="active">Production</li>
@endsection


@section('page-header')
    <h1>Production
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Settings</small>
    </h1>
@endsection

@section('main-content')
<?php
$edit_permission=DB::table('rs_production_user_list')->where('user_id',session('user_id'))->first();
?>
<form class="form-horizontal" role="form" action="{{URL::to('production_schedule_chart')}}" method="POST">
    @csrf


        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Date </label>

                <div class="col-sm-4">
                <input name="year" value="{{$year}}" class="col-xs-10 col-sm-4" type="text" autocomplete="off">

                <div class="col-sm-5">
                
                <select name="month">
                               <option value="{{$monthid}}" selected>{{$monthname}}</option>
                               @if($monthname!='January')
                               <option value="1">January</option>
                               @endif
                               @if($monthname!='February')
                               <option value="2">February</option>
                               @endif
                               @if($monthname!='March')
                               <option value="3">March</option>
                               @endif
                               @if($monthname!='April')
                               <option value="4">April</option>
                               @endif
                               @if($monthname!='May')
                               <option value="5">May</option>
                               @endif
                               @if($monthname!='June')
                               <option value="6">June</option>
                               @endif
                               @if($monthname!='July')
                               <option value="7">July</option>
                               @endif
                               @if($monthname!='August')
                               <option value="8">August</option>
                               @endif
                               @if($monthname!='September')
                               <option value="9">September</option>
                               @endif
                               @if($monthname!='October')
                               <option value="10">October</option>
                               @endif
                               @if($monthname!='November')
                               <option value="11">November</option>
                               @endif
                               @if($monthname!='December')
                               <option value="12">December</option>
                               @endif
                              
                    </select>
                </div>

                </div>

            
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Department </label>

            <div class="col-sm-4">
            <select name="department" class="chosen-container chosen-container-single chosen-select ">
                              <option value="{{$departmentid}}" selected>{{$departmentname}}</option>
                               @foreach($dept as $each_dept)
                               @if($each_dept->id!=$departmentid)
                              <option value="{{$each_dept->id}}">{{$each_dept->department}}</option>
                              @endif
                              @endforeach
                    </select>
            </div>

           
        </div>
        

            <div class="col-md-offset-3 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Modify Search
                </button>
            </div>
		
         
    </form>
    <br><br>
    <div class="hr hr-20 hr-dotted"></div>
    
    <div class="col-md-offset-9 col-md-6">
                <button class="btn btn-info" id="publish">
                    <i class="ace-icon fa fa-download bigger-110"></i>
                    Publish Production Tracker
                </button>
            </div>
    <br><br><br>
    <table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        <th class="detail-col">Plan</th>
        <th>Name</th>
        
    </tr>
    </thead>
    <tbody>
    @if($subdept)
        @foreach($subdept as $each_dept)
        <tr>
            <td class="center">
                <div class="action-buttons">
                    <a href="#" class="green bigger-140 show-details-btn" title="Show Plan">
                        <i class="ace-icon fa fa-angle-double-down"></i>
                        <span class="sr-only">Plan</span>
                    </a>
                </div>
            </td>
            <td>
                <a href="#!">{{$each_dept->name}}</a>
            </td>
            

        </tr>
        <tr class="detail-row">
            <td colspan="8">

            <table id="simple-table" class="table  table-bordered table-hover">
    <thead>
    <tr>
        
        <th>Day</th>
        <th>Planned</th>
        <th>Achived</th>
        <th>Difference</th>
        <th>Last Edited By</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $production_chart=DB::table('rs_production_chart')->where('subdept_id',$each_dept->id)->where('month',$monthid)->where('year',$year)->get();
        $total_planned=DB::table('rs_production_chart')->where('subdept_id',$each_dept->id)->where('month',$monthid)->where('year',$year)->sum('planned');
        $total_achived=DB::table('rs_production_chart')->where('subdept_id',$each_dept->id)->where('month',$monthid)->where('year',$year)->sum('achived');
        $total_difference=DB::table('rs_production_chart')->where('subdept_id',$each_dept->id)->where('month',$monthid)->where('year',$year)->sum('difference');
        ?>
        @if($production_chart)
        @foreach($production_chart as $each_entry)
        <?php
        $sunday_check=date("l", mktime(0, 0, 0, $monthid, $each_entry->day, $year));
        $user_name=DB::table('users')->where('id',$each_entry->last_edited)->value('name');
        ?>
        @if($sunday_check=='Sunday')
        <tr bgcolor="yellow">
        <td>{{$each_entry->day}}</td>
        <td>{{$each_entry->planned}}</td>
        <td>{{$each_entry->achived}}</td>
        <td>{{$each_entry->difference}}</td>
        <td>-</td>
        </tr>
        @else
        <tr>
        <td>{{$each_entry->day}}</td>
        @if($edit_permission)
        <td class="planned_entry" entry-id="{{$each_entry->id}}" contenteditable>{{$each_entry->planned}}</td>
        <td class="achived_entry" entry-id="{{$each_entry->id}}" contenteditable>{{$each_entry->achived}}</td>
        @else
        <td>{{$each_entry->planned}}</td>
        <td>{{$each_entry->achived}}</td>
        @endif
        @if($each_entry->difference>0)
        <td><font color="green">{{$each_entry->difference}}</font></td>
        @endif
        @if($each_entry->difference<0)
        <td><font color="red">{{abs($each_entry->difference)}}</font></td>
        @endif
        @if($each_entry->difference==0)
        <td>{{$each_entry->difference}}</td>
        @endif
        <td>{{$user_name}}</td>
        </tr>
        @endif
        @endforeach
        @endif
        <tr>
                    <td>Monthly Total</td>
                    <td>Planned: {{$total_planned}}</td>
                    <td>Achived: {{$total_achived}}</td>
                    @if($total_difference>0)
                    <td>Difference: <font color="green">{{$total_difference}}</font></td>
                    @endif
                    @if($total_difference<0)
                    <td>Difference: <font color="red">{{abs($total_difference)}}</font></td>
                    @endif
                    @if($total_difference==0)
                    <td>Difference: {{$total_difference}}</td>
                    @endif
                    <td>-</td>
                </tr>
    
    </tbody>
</table>
                
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
</table>


   
<!-- Ajax call url       -->
<input type="hidden" value="{{URL::to('production_ajax')}}" id="url_ajax">


@endsection

@section('js-files')
<!-- Custom File -->
<script src="{{ asset('productions_js/production_chart.js') }}" defer></script>
@endsection