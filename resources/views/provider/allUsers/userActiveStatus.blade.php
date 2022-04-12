<form class="form-horizontal form-validate-jquery" action="{{route('provider.userActiveStatusAction', [$user->id] )}}" method="POST">
    @csrf
    <div class="panel panel-flat">
        <div class="panel-body" id="modal-container">
            <select class="select2 select-search col-lg-8" id="select_status" name="active_status" required="">
                <option value="">Select Status</option>
                    <option value="0" @if (@$user->active_status == 0) selected @endif>Pending</option>
                    <option value="1" @if (@$user->active_status == 1) selected @endif>Approved</option>
                    <option value="2" @if (@$user->active_status == 2) selected @endif>Decline</option>
            </select>
        </div>
    </div>
</form>
<script type="text/javascript">
	$("#select_status").select2({ dropdownParent: "#modal-container" });
</script>
