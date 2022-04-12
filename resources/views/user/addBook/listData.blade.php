@extends('user.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('user.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('user.addBook.index')}}">Books</a></li>
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
            <h5 class="panel-title">Book List</h5>
            <div class="heading-elements">
                <ul class="icons-list" style="margin-top: 0px">
                    <li style="margin-right: 10px;"><a href="{{route('user.addBook.create')}}" class="btn btn-primary add-new">Add New</a></li>
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
                    <th width="10%">Thumb</th>
                    <th width="20%">Title</th>
                    <th width="10%">Category</th>
                    <th width="25%">Summery</th>
                    <th width="15%">Total Pages</th>
                    <th width="10%">Author</th>
                    <th width="5%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($books))
                    @foreach ($books as $key => $book)
                    <tr>
                        <td>{{++$key}}</td>
                        <td><img src="{{ asset('uploads/book/thumb/'.$book->book_thumb)}}" width="70" alt=""></td>
                        <td>{{$book->title}}</td>
                        <td>{{$book->category_name}}</td>
                        <td>{{Str::words(strip_tags($book->summery), 10)}}</td>
                        <td>{{$book->number_of_page}}</td>
                        <td>{{$book->author_name}}</td>
                        <td class="text-center">
                            <a href="{{route('user.addBook.edit', [$book->id])}}" class="action-icon"><i class="icon-pencil7"></i></a>
                            <a href="#" class="action-icon"><i class="icon-trash" id="delete" delete-link="{{route('user.addBook.destroy', [$book->id])}}">@csrf </i></a>
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
