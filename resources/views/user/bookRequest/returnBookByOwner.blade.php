<form class="form-horizontal form-validate-jquery" action="{{route('user.bookRequest.returnBookByOwnerAction', [$bookRequest->id] )}}" method="POST">
    @csrf
    <div class="panel panel-flat">
        <div class="panel-body" id="modal-container">
            <p style="padding-left: 10px;">
                Book returned by <b>{{$bookRequest->user_first_name}}</b> 
            </p>
            <select class="select2 select-search col-lg-8" id="select_status" name="return_accept_by_owner_status" required="">
                <option value="1" @if (@$bookRequest->return_accept_by_owner_status == 1) selected @endif>Received</option>
                <option value="0" @if (@$bookRequest->return_accept_by_owner_status == 0) selected @endif>Not Received</option>
            </select>
        </div>
    </div>
</form>
<script type="text/javascript">
	$("#select_status").select2({ dropdownParent: "#modal-container" });
</script>
