@extends('provider.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('provider.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('provider.allUsers.index')}}">All Users</a></li>
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
            <h5 class="panel-title">Users List</h5>
            <div class="heading-elements">
                <ul class="icons-list" style="margin-top: 0px">
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
                    <th width="10%">image</th>
                    <th width="20%">Name</th>
                    <th width="20%">Email</th>
                    <th width="10%">Phone</th>
                    <th width="20%">Address</th>
                    <th width="10%">Active Status</th>
                    <th width="10%">Books</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($users))
                    @foreach ($users as $key => $user)
                    <tr>
                        <td>{{++$key}}</td>
                        <td><img src="{{ asset('uploads/userProfile/thumb/'.$user->image)}}" class="" alt="{{$user->image}}" width="100"></td>
                        <td>{{$user->first_name.' '. $user->last_name}}</td>
                        <td> {{$user->email}} </td>
                        <td> {{$user->phone}} </td>
                        <td> {{$user->address}} </td>
                        <td>
                            @if ($user->active_status == 0)
                                <span class="text-warning">Pending</span>
                            @elseif($user->active_status == 1)
                                <span class="text-success">Approved</span>
                            @else
                                <span class="text-danger">Decline</span>
                            @endif
                            <button type="button" class="btn btn-info btn-xs mb-5 open-modal" modal-title="User Active Status Update" modal-type="update" modal-size="medium" modal-class="" selector="Assign" modal-link="{{route('provider.userActiveStatus', [$user->id])}}"> Approve Status </button>
                        </td>
                        <td>
                            @php($totalBook = DB::table('books')->where('created_by', $user->id)->count())
                            <a href="{{ route('provider.bookListByUser', [$user->id]) }}" class="btn btn-success btn-xs">View Books</a>
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
                {'orderable':false, "targets": 1 }
            ]
    });
</script>
@endpush
