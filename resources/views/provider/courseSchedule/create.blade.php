@extends('provider.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('provider.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('provider.scheduledList.index')}}">Schedule</a></li>
            <li class="active">Create</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">

    <!-- Form validation -->
    <div class="panel panel-flat">
        <div class="panel-heading" style="border-bottom: 1px solid #ddd; margin-bottom: 20px;">
            <h5 class="panel-title">Schedule Create</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <form class="form-horizontal form-validate-jquery" action="{{route('provider.scheduledList.store')}}" method="POST">
                @csrf
                <fieldset class="content-group">
                    @if (session('msgType'))
                        <div id="msgDiv" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">{{ session('msgType') }}!</span> {{ session('messege') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-styled-left alert-bordered">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Opps!</span> {{ $error }}.
                        </div>
                        @endforeach
                    @endif
                    <!-- Basic text input -->
                    <input type="hidden" name="assign_course_id" value="{{$assign_id}}">
                    <div class="form-group">
                        <label class="control-label col-lg-2">Select Batch</label>
                        <div class="col-lg-10">
                            <select class="select-search" name="batch_no">
                                <option value="">Select</option>
                                <?php
                                    for ($i=1; $i <= 10; $i++) { 
                                ?>
                                    <option value="<?php echo $i;?>">Batch <?php echo $i;?></option>
                                <?php
                                    }
                                ?>   
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Schedule Title <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="schedule_title" class="form-control" required="required" placeholder="Schedule Title">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Start Date</label>
                        <div class="col-md-10">
                            <input class="form-control" type="date" name="start_date">
                            <span class="help-block">Using <code>input type="date"</code></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Start Time</label>
                        <div class="col-md-10">
                            <input class="form-control" type="time" name="start_time">
                            <span class="help-block">Using <code>input type="time"</code></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Schedule Url <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="start_url" class="form-control" required="required" placeholder="Schedule Url">
                        </div>
                    </div>
                    <!-- /basic text input -->

                </fieldset>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                    <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
                    <a href="{{route('provider.scheduledList.index', ['assign_id'=>$assign_id])}}" class="btn btn-default">Back To List <i class="icon-backward2 position-right"></i></a>
                </div>
            </form>
        </div>
    </div>
    <!-- /form validation -->


    <!-- Footer -->
    <div class="footer text-muted">
        &copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
    </div>
    <!-- /footer -->

</div>
<!-- /content area -->
@endsection

@push('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        @if (session('msgType'))
            setTimeout(function() {$('#msgDiv').hide()}, 3000);
        @endif
    })
</script>
@endpush
