<form class="form-horizontal form-validate-jquery" action="{{route('provider.author.authorActiveStatusAction', [$author->id] )}}" method="POST">
    @csrf
    <div class="panel panel-flat">
        <div class="panel-body" id="modal-container">
            <select class="select2 select-search col-lg-8" id="select_status" name="active_status" required="">
                <option value="1" @if (@$author->active_status == 1) selected @endif>Active</option>
                <option value="0" @if (@$author->active_status == 0) selected @endif>Pending</option>
            </select>
        </div>
    </div>
</form>
<script type="text/javascript">
	$("#select_status").select2({ dropdownParent: "#modal-container" });
</script>
