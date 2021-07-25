@extends('provider.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('provider.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('provider.teacher.index')}}">Course Teacher</a></li>
            <li class="active">Update</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">

    <!-- Form validation -->
    <div class="panel panel-flat">
        <div class="panel-heading" style="border-bottom: 1px solid #ddd; margin-bottom: 20px;">
            <h5 class="panel-title">Course Teacher Update</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <form class="form-horizontal form-validate-jquery" action="{{route('provider.teacher.update', [$teacher_info->id])}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
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
                    <div class="form-group">
                        <label class="control-label col-lg-2">Teacher Name <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="teacher_name" class="form-control" required="required" placeholder="Teacher Name" value="{{$teacher_info->teacher_name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Teacher Email</label>
                        <div class="col-lg-10">
                            <input type="email" name="teacher_email" class="form-control" placeholder="Teacher Email" value="{{$teacher_info->teacher_email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Teacher Phone</label>
                        <div class="col-lg-10">
                            <input type="text" name="teacher_phone" class="form-control" placeholder="Teacher Phone" value="{{$teacher_info->teacher_phone}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qualifications" class="control-label col-lg-2">Qualifications <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <textarea name="qualifications" id="qualifications" class="form-control" required="required">{{$teacher_info->qualifications}}</textarea>
                        </div>
                    </div>
                    <!-- /basic text input -->
                    <!-- Image input -->
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-semibold">Teacher Image</label>
                        <div class="col-lg-6">
                            <div class="file-preview" id="custom_file_preview">
                                <div class="close fileinput-remove text-right" id="custom_close">×</div>
                                <div class="file-preview-thumbnails">
                                    <div class="file-preview-frame" id="preview-1603644588432-0">
                                        <img src="{{ asset('uploads/courseTeacher/'.$teacher_info->teacher_image)}}" class="file-preview-image" title="{{$teacher_info->teacher_image}}" alt="{{$teacher_info->teacher_image}}" style="width:auto;height:160px;">
                                    </div>
                                </div>
                                <div class="clearfix"></div>   
                                <div class="file-preview-status text-center text-success"></div>
                                <div class="kv-fileinput-error file-error-message" style="display: none;"></div>
                                <input type="hidden" name="teacher_image" value="{{$teacher_info->teacher_image}}">
                            </div>
                            <div id="custom_file_input" style="display: none;">
                                <input type="file" name="teacher_image" class="file-input-extensions">
                                <span class="help-block">Allow extensions: <code>jpg</code>, <code>png</code> and <code>jpeg</code> and  Allow Size: <code>300 * 380</code> Only</span>
                            </div>
                        </div>
                    </div>
                    <!-- /Image input -->
                </fieldset>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                    <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
                    <a href="{{route('provider.teacher.index')}}" class="btn btn-default">Back To List <i class="icon-backward2 position-right"></i></a>
                </div>
            </form>
        </div>
    </div>
    <!-- /form validation -->

</div>
<!-- /content area -->
@endsection

@push('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        @if (session('msgType'))
            setTimeout(function() {$('#msgDiv').hide()}, 3000);
        @endif

        $("#qualifications").summernote({
            height: 150
        });
    })
</script>
@endpush
