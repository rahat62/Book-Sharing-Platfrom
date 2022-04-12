
<div class="table-responsive">
    <table class="table table-bordered table-framed">
        <thead>
            <tr>
                <td colspan="2" style="text-align: center">
                    <img src="{{ asset('uploads/userProfile/thumb/'.$ownerDetails->image) }}" width="140" alt="{{$ownerDetails->name}}">
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Name </th>
                <td>{{$ownerDetails->first_name.' '.$ownerDetails->last_name}}</td>
            </tr>
            <tr>
                <th>Phone </th>
                <td>{{$ownerDetails->phone}}</td>
            </tr>
            <tr>
                <th>Email </th>
                <td>{{$ownerDetails->email}}</td>
            </tr>
            <tr>
                <th>Address </th>
                <td>{{$ownerDetails->address}}</td>
            </tr>
        </tbody>
    </table>
</div>
        