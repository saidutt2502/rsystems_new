@extends('layouts.user-master')

@section('main-content')
<div class="col-sm-12">
    <div class="widget-box transparent">
        <div class="widget-header widget-header-small">
            <h4 class="widget-title blue smaller">
														<i class="ace-icon fa fa-rss orange"></i>
														Recent Activities
													</h4>

            <div class="widget-toolbar action-buttons">
                <a href="#" data-action="reload">
                    <i class="ace-icon fa fa-refresh blue"></i>
                </a>
                &nbsp;
                <a href="#" class="pink">
                    <i class="ace-icon fa fa-trash-o"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-8">
                <div id="profile-feed-1" class="profile-feed">
                    <div class="profile-activity clearfix">
                        <div>
                            <img class="pull-left" alt="Alex Doe's avatar" src="/core/images/avatars/avatar2.png" />
                            <a class="user" href="#"> Aman Sharma </a> : Too much kaam is left
                            <div class="time">
                                <i class="ace-icon fa fa-clock-o bigger-110"></i> 8 hour ago
                            </div>
                        </div>

                        <div class="tools action-buttons">
                            <a href="#" class="blue">
                                <i class="ace-icon fa fa-pencil bigger-125"></i>
                            </a>

                            <a href="#" class="red">
                                <i class="ace-icon fa fa-times bigger-125"></i>
                            </a>
                        </div>
                    </div>

                     <div class="profile-activity clearfix">
                        <div>
                            <img class="pull-left" alt="Alex Doe's avatar" src="/core/images/avatars/avatar2.png" />
                            <a class="user" href="#"> Aman Sharma </a> : Also This is hardcoded :P
                            <div class="time">
                                <i class="ace-icon fa fa-clock-o bigger-110"></i> 10 hour ago
                            </div>
                        </div>

                        <div class="tools action-buttons">
                            <a href="#" class="blue">
                                <i class="ace-icon fa fa-pencil bigger-125"></i>
                            </a>

                            <a href="#" class="red">
                                <i class="ace-icon fa fa-times bigger-125"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hr hr2 hr-double"></div>

    <div class="space-6"></div>

    <div class="center">
        <button type="button" class="btn btn-sm btn-primary btn-white btn-round">
            <i class="ace-icon fa fa-rss bigger-150 middle orange2"></i>
            <span class="bigger-110">View more activities</span>

            <i class="icon-on-right ace-icon fa fa-arrow-right"></i>
        </button>
    </div>
</div> 

<!-- Approval count -->
<input value="{{$count}}" id="count" type="hidden">
           
@endsection

@section('js-files')
    <script src="{{ asset('home.js') }}" defer></script>

@endsection