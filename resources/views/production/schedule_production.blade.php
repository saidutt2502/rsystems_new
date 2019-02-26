@extends('layouts.user-master')


@section('css-files')
    <link rel="stylesheet" href="/core/css/bootstrap-duallistbox.min.css" />
@endsection



@section('breadcrumb')
    <li class="active">Production</li>
@endsection


@section('page-header')
    <h1>Production
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Tracker</small>
    </h1>
@endsection

@section('main-content')
<form class="form-horizontal" role="form" action="{{URL::to('production_schedule_chart')}}" method="POST">
    @csrf


        <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Month &amp Year </label>

                <div class="col-sm-4">
                <!-- <label class="control-label no-padding-right">Year</label> -->
                <select name="year">
                    <?php
                    $current_year=date("Y");
                    ?>
                    <option selected value="{{$current_year}}" >{{$current_year}}</option>
                    <?php
                    for($i=2019;$i<=2100;$i++)
                    {
                        if($i!=$current_year)
                        {
                    ?>
                       
                       <option value="{{$i}}">{{$i}}</option>
                    <?php
                        }
                    }
                    ?>           
                              
                    </select>

                <div class="col-sm-5">
                
                <select name="month">
                               <option selected disabled>Select Month</option>
                               <option value="1">January</option>
                               <option value="2">February</option>
                               <option value="3">March</option>
                               <option value="4">April</option>
                               <option value="5">May</option>
                               <option value="6">June</option>
                               <option value="7">July</option>
                               <option value="8">August</option>
                               <option value="9">September</option>
                               <option value="10">October</option>
                               <option value="11">November</option>
                               <option value="12">December</option>
                              
                    </select>
                </div>

                </div>

            
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Department </label>

            <div class="col-sm-4">
            <select name="department" class="chosen-container chosen-container-single chosen-select ">
                               <option selected disabled>Select Department</option>
                               @foreach($dept as $each_dept)
                              <option value="{{$each_dept->id}}">{{$each_dept->department}}</option>
                              @endforeach
                    </select>
            </div>

           
        </div>
       



        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Search
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
		</div>
        *Please click SUBMIT only once and allow a few seconds for form submission. 
    </form>


   
<!-- Ajax call url       -->


@endsection

@section('js-files')
@endsection