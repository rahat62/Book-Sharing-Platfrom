@extends('provider.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('provider.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('provider.course.index')}}">Course</a></li>
            <li class="active">List Data</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">

    <!-- Highlighting rows and columns -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Course List</h5>
            <div class="heading-elements">
                <ul class="icons-list" style="margin-top: 0px">
                    <li style="margin-right: 10px;"><a href="{{route('provider.course.create')}}" class="btn btn-primary add-new">Add New</a></li>
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <table class="table table-bordered table-hover datatable-highlight data-list" id="courseTable">
            <thead>
                <tr>
                    <th width="5%">SL.</th>
                    <th width="25%">Course Name</th>
                    <th width="20%">Course Thumb</th>
                    <th width="10%">Duration</th>
                    <th width="15%">Teacher</th>
                    <th width="10%" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($all_courses))
                    @foreach ($all_courses as $key => $course)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$course->course_name}}</td>
                        <td><img src="{{ asset('uploads/course/thumb/'.$course->course_thumb)}}" alt=""></td>
                        <td>{{$course->duration}} days</td>
                        <td>
                            <a href="{{route('provider.courseAssignTeacher', [$course->id])}}" class="btn btn-info btn-xs">Assign Teacher</a>
                        </td>
                        <td class="text-center">
                            <a href="{{route('provider.course.edit', [$course->id])}}" class="action-icon"><i class="icon-pencil7"></i></a>
                            <a href="#" class="action-icon"><i class="icon-trash" id="delete" delete-link="{{route('provider.course.destroy', [$course->id])}}">@csrf </i></a>
                        </td>
                    </tr> 
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No Data Found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /highlighting rows and columns -->

</div>
<!-- /content area -->
@endsection

@push('javascript')
<script type="text/javascript">
    // $('#courseTable').DataTable();
    
    $('#courseTable').DataTable({
        dom: 'lBfrtip',
            "iDisplayLength": 10,
            "lengthMenu": [ 10, 25,30, 50 ],
            columnDefs: [
                {'orderable':false, "targets": 2 },
                {'orderable':false, "targets": 4 },
                {'orderable':false, "targets": 5 },
            ]
    });
</script>
@endpush
