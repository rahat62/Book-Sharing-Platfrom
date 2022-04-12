@extends('user.layouts.default')

@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('user.home')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('user.addBook.index')}}">Photo Gallery</a></li>
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
            <h5 class="panel-title">Photo Gallery Update</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <form class="form-horizontal form-validate-jquery" action="{{route('user.addBook.update', [$book->id])}}" method="POST" enctype="multipart/form-data">
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
                        <label class="control-label col-lg-2">Title <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" name="title" class="form-control" required="required" placeholder="Title" value="{{$book->title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Select Category <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="select-search" name="category_id" required="required">
                                <option value="">Select</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $book->category_id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Summery <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <textarea name="summery" id="summery" class="form-control" required="required" placeholder="Book Summery">{{$book->summery}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Total Pages <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="number" name="number_of_page" class="form-control" required="required" placeholder="Total Pages" value="{{$book->number_of_page}}" pattern="^[0-9+\s\.]+$">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2">Author <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="select-search" name="author_id" required="required">
                                <option value="">Select</option>
                                @foreach ($authors as $author)
                                <option value="{{$author->id}}" {{$author->id == $book->author_id ? 'selected' : ''}}>{{$author->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-2">Language <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="select-search" name="language_id" required="required">
                                <option value="">Select</option>
                                @foreach ($languages as $language)
                                <option value="{{$language->id}}" {{$language->id == $book->author_id ? 'selected' : ''}}>{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /basic textarea -->

                    <!-- Image input -->
                    <div class="form-group">
                        <label class="col-lg-2 control-label text-semibold">Book Thumb</label>
                        <div class="col-lg-6">
                            <div class="file-preview" id="custom_file_preview">
                                <div class="close fileinput-remove text-right" id="custom_close">×</div>
                                <div class="file-preview-thumbnails">
                                    <div class="file-preview-frame" id="preview-1603644588432-0">
                                        <img src="{{ asset('uploads/book/'.$book->book_thumb)}}" class="file-preview-image" title="{{$book->book_thumb}}" alt="{{$book->book_thumb}}" style="width:auto;height:160px;">
                                    </div>
                                </div>
                                <div class="clearfix"></div>   
                                <div class="file-preview-status text-center text-success"></div>
                                <div class="kv-fileinput-error file-error-message" style="display: none;"></div>
                                <input type="hidden" name="book_thumb" value="{{$book->book_thumb}}">
                            </div>
                            <div id="custom_file_input" style="display: none;">
                                <input type="file" name="book_thumb" class="file-input-extensions">
                                {{-- zz<span class="help-block">Allow extensions: <code>jpg</code>, <code>png</code> and <code>jpeg</code> and  Allow Size: <code>450 * 460</code> Only</span> --}}
                            </div>
                        </div>
                    </div>

                </fieldset>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
                    <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
                    <a href="{{route('user.addBook.index')}}" class="btn btn-default">Back To List <i class="icon-backward2 position-right"></i></a>
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
            setTimeout(function() {$('#msgDiv').hide()}, 6000);
        @endif

        $("#summery").summernote({
            height: 150
        });
    })
</script>
@endpush