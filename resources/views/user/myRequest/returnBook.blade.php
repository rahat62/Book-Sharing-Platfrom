<form class="form-horizontal form-validate-jquery" action="{{route('user.myRequest.returnBookAction', [$bookRequest->id] )}}" method="POST">
    @csrf
    <div class="panel panel-flat">
        <div class="panel-body" id="modal-container">
            <select class="select2 select-search col-lg-8" id="select_status" name="return_by_borrower_status" required="">
                <option value="1" @if (@$bookRequest->return_by_borrower_status == 1) selected @endif>Yes</option>
                <option value="0" @if (@$bookRequest->return_by_borrower_status == 0) selected @endif>No</option>
            </select>
        </div>
    </div>
</form>
<script type="text/javascript">
	$("#select_status").select2({ dropdownParent: "#modal-container" });
</script>
