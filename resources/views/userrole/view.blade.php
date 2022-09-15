    <div class="row">
        <div class="col-md-12">
            <table id="table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Page Name</th>
                        <th>Read right</th>
                        <th>Write right</th>
                        <th>Edit right</th>
                        <th>Delete right</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userroledata as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->pagename}}</td>
                        <td>
                            @if($data->readright==1)
                            Yes
                            @elseif($data->readright==0)
                            No
                            @endif
                        </td>
                        <td>
                            @if($data->addright==1)
                            Yes
                            @elseif($data->addright==0)
                            No
                            @endif
                        </td>
                        <td>
                            @if($data->editright==1)
                            Yes
                            @elseif($data->editright==0)
                            No
                            @endif
                        </td>
                        <td>
                            @if($data->deleteright==1)
                            Yes
                            @elseif($data->deleteright==0)
                            No
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>