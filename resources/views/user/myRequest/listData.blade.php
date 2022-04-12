@extends('user.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('user.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('user.addBook.index')}}">My Request</a></li>
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
            <h5 class="panel-title">My Book Request List</h5>
            {{-- <div class="heading-elements">
                <ul class="icons-list" style="margin-top: 0px">
                    <li style="margin-right: 10px;"><a href="{{route('user.addBook.create')}}" class="btn btn-primary add-new">Add New</a></li>
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div> --}}
        </div>

        @if (session('msgType'))
            @if(session('msgType') == 'danger')
                <div id="msgDiv" class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                    <span class="text-semibold">{{ session('msgType') }}!</span> {{ session('messege') }}
                </div>
            @else
            <div id="msgDiv" class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">{{ session('msgType') }}!</span> {{ session('messege') }}
            </div>
            @endif
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-styled-left alert-bordered">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                <span class="text-semibold">Opps!</span> {{ $error }}.
            </div>
            @endforeach
        @endif

        <table class="table table-bordered table-hover datatable-highlight data-list" id="bookRequestListTable">
            <thead>
                <tr>
                    <th width="5%">SL.</th>
                    <th width="5%">Thumb</th>
                    <th width="15%">Book Id</th>
                    <th width="20%">Title</th>
                    <th width="15%">Owner</th>
                    <th width="10%">Author</th>
                    <th width="20%">Return Status</th>
                    <th width="5%" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($bookRequestInfos))
                    @foreach ($bookRequestInfos as $key => $bookRequestInfo)
                    <tr>
                        <td>{{++$key}}</td>
                        <td><img src="{{ asset('uploads/book/thumb/'.$bookRequestInfo->book_thumb)}}" alt=""></td>
                        <td>{{$bookRequestInfo->book_id}}</td>
                        <td>{{$bookRequestInfo->book_title}}</td>
                        <td>{{$bookRequestInfo->user_first_name. ' '.$bookRequestInfo->user_last_name}}</td>
                        <td>{{$bookRequestInfo->author_name}}</td>
                        <td>
                            @if ($bookRequestInfo->status == 1)
                                <button type="button" class="btn btn-info btn-xs mb-5 open-modal" modal-title="Return Book" modal-type="update" modal-size="medium" modal-class="" selector="Assign" modal-link="{{route('user.myRequest.returnBook', [$bookRequestInfo->id])}}"  {{$bookRequestInfo->return_by_borrower_status == 1 ? 'disabled' : ''}}> {{$bookRequestInfo->return_by_borrower_status == 1 ? 'Returned' : 'Return Book '}} </button>
                            @endif
                            @if ($bookRequestInfo->return_accept_by_owner_status == 1)
                                <span class="text-success">Owner received the book</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($bookRequestInfo->status == 1)
                            <span class="label label-success">Accepted</span>

                            <button type="button" class="btn btn-info btn-xs mb-5 open-modal" modal-title="Owner Details" modal-type="show" modal-size="medium" modal-class="" selector="Assign" modal-link="{{route('user.myRequest.ownerDetails', [$bookRequestInfo->owner_id])}}">Contact With Owner</button>

                            @elseif($bookRequestInfo->status == 2)
                            <span class="label label-danger">Rejected</span>
                            @else
                            <span class="label label-warning">Pending</span>
                            @endif
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
    // $('#bookRequestListTable').DataTable();
    
    $('#bookRequestListTable').DataTable({
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
