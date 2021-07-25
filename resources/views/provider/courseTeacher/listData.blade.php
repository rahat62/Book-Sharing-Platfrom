@extends('provider.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('provider.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('provider.teacher.index')}}">Course Teacher</a></li>
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
            <h5 class="panel-title">Course Teacher List</h5>
            <div class="heading-elements">
                <ul class="icons-list" style="margin-top: 0px">
                    <li style="margin-right: 10px;"><a href="{{route('provider.teacher.create')}}" class="btn btn-primary add-new">Add New</a></li>
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <table class="table table-bordered table-hover datatable-highlight data-list" id="teacherTable">
            <thead>
                <tr>
                    <th width="5%">SL.</th>
                    <th width="20%">Teacher Name</th>
                    <th width="15%">Email</th>
                    <th width="15%">Phone</th>
                    <th width="35%">Qualifications</th>
                    <th width="10%" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($all_teachers))
                    @foreach ($all_teachers as $key => $teacher)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$teacher->teacher_name}}</td>
                        <td>{{$teacher->teacher_email}}</td>
                        <td>{{$teacher->teacher_phone}}</td>
                        <td>{!! Str::words($teacher->qualifications, 20, '.....') !!}</td>
                        <td class="text-center">
                            <a href="{{route('provider.teacher.edit', [$teacher->id])}}" class="action-icon"><i class="icon-pencil7"></i></a>
                            <a href="#" class="action-icon"><i class="icon-trash" id="delete" delete-link="{{route('provider.teacher.destroy', [$teacher->id])}}">@csrf </i></a>
                        </td>
                    </tr> 
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No Data Found!</td>
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
    // $('#teacherTable').DataTable();
    
    $('#teacherTable').DataTable({
        dom: 'lBfrtip',
            "iDisplayLength": 10,
            "lengthMenu": [ 10, 25,30, 50 ],
            columnDefs: [
                {'orderable':false, "targets": 4 }
            ]
    });
</script>
@endpush
