@extends('layouts.user-master')

@section('breadcrumb')
    <li class="active">Gatepass</li>
@endsection


@section('page-header')
    <h1>Gatepass
        <small><i class="ace-icon fa fa-angle-double-right"></i>&nbsp;&nbsp;&nbsp;Settings</small>
    </h1>
@endsection

@section('main-content')

@if($count==0)
    <form class="form-horizontal" role="form" action="{{URL::to('gatepass_settings')}}" method="POST">
    @csrf

    <button type="button" class="btn btn-primary btn-clone btn-md" style="float:right" id="add">
        <i class="ace-icon fa fa-plus bigger-110 icon-only"></i>
    </button>

    <div class="form-group">
        <div class="col-md-3 col-sm-3">
            <div class="col-md-12">
                 <label>Hours/Employee/Month</label>
                     <input autocomplete="off" type="text" class="form-control" name="hours"  required>
            </div>
        </div>
   </div>
        <div class="form-group" id="add_shift" >
            <div class="col-md-12">
                <div class="col-md-3 col-sm-3">
                 <label>Shift Name</label>
                     <input autocomplete="off" type="text" class="form-control" name="name[]" required autofocus><br>
                </div>

                <div class="col-md-2 col-sm-2">
                 <label>From</label>
                     <input autocomplete="off" type="time" class="form-control" name="from[]"  required>
                </div>

                <div class="col-md-2 col-sm-2">
                 <label>To</label>
                     <input autocomplete="off" type="time" class="form-control" name="to[]"  required>
                </div>

            </div>
        </div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset" id="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
		</div>
    </form>

    @else
    <form class="form-horizontal" role="form" action="{{URL::to('gatepass_settings')}}" method="POST">
    @csrf

    <button type="button" class="btn btn-primary btn-clone btn-md" style="float:right" id="add">
        <i class="ace-icon fa fa-plus bigger-110 icon-only"></i>
    </button>

    <div class="form-group">
        <div class="col-md-3 col-sm-3">
            <div class="col-md-12">
                 <label>Hours/Employee/Month</label>
                     <input autocomplete="off" value="{{$hours}}" type="text" class="form-control" name="hours"  required>
            </div>
        </div>
   </div>


    <div class="form-group" id="add_shift" >
    @foreach($entries as $entry)
    <div class="col-md-12">
                <div class="col-md-3 col-sm-3">
                 <label>Shift Name</label>
                     <input autocomplete="off" type="text" class="form-control" name="name[]" value="{{$entry->name}}" required autofocus><br>
                </div>

                <div class="col-md-2 col-sm-2">
                 <label>From</label>
                     <input autocomplete="off" type="time" class="form-control" name="from[]" value="{{$entry->from}}"  required>
                </div>

                <div class="col-md-2 col-sm-2">
                 <label>To</label>
                     <input autocomplete="off" type="time" class="form-control" name="to[]" value="{{$entry->to}}"  required>
                </div>

                @if($counter!=$count)
                <div class="col-md-2 col-sm-2">
                    <br><button type="button" class="btn btn-sm btn-danger del_btn">-</button>
                </div>
                @endif
                <?php $counter--
                ?>
    </div>
    @endforeach
    </div>

        <div class="clearfix form-actions">
            <div class="col-md-offset-5 col-md-6">
                <button class="btn btn-info" type="submit">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Submit
                </button>

                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset" id="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    Reset
                </button>
            </div>
		</div>
    </form>

    @endif

@endsection

@section('js-files')
    <!-- Custom File -->
    <script src="{{ asset('gatepass/settings.js') }}" defer></script>
@endsection