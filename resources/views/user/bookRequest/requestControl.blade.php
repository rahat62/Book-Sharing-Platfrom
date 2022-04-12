<form class="form-horizontal form-validate-jquery" action="{{route('user.bookRequest.requestControlAction', [$bookRequestInfo->id, 'book_id'=>$bookRequestInfo->book_id] )}}" method="POST">
    @csrf
    <div class="panel panel-flat">
        <div class="panel-body" id="modal-container">
            <select class="select2 select-search col-lg-8" id="select_status" name="status" required="">
                <option value="1" @if (@$bookRequestInfo->status == 1) selected @endif>Accept</option>
                <option value="2" @if (@$bookRequestInfo->status == 2) selected @endif>Reject</option>
            </select>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("#select_status").select2({ dropdownParent: "#modal-container" });
</script>
    