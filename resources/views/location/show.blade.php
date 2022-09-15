<div class="row">
        <div class="col-md-12">
            <table id="table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Location Name</th>
                        <th>State</th>
                        <th>District</th>
                        <th>Taluk</th>
                        <th>Village</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locationdata as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->locationname}}</td>
                        <td>{{$data->state}}</td>
                        <td>{{$data->district}}</td>
                        <td>{{$data->taluk}}</td>
                        <td>{{$data->village}}</td>
                        <td>{{$data->address}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>