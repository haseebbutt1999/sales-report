<table id="datatabled" class="table table-borderless  table-hover  table-class " >
    <thead class="border-0 ">
    <tr class="th-tr table-tr text-white text-center" >
        <th class="font-weight-bold">Title</th>
        <th class="font-weight-bold">Description</th>
        <th class="font-weight-bold">Action</th>
    </tr>
    </thead>
    <tbody >
    @foreach($package_data as $key=>$package)
        <tr class="td-text-center">
            <td>{{$package->title}}</td>
            <td>{{$package->description}}</td>
            <td>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <form action="{{Route('edit.package', $package->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-lg btn-primary">Edit</button>
                    </form>
                    <form action="{{Route('delete.package', $package->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-lg btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>s
    @endforeach
    </tbody>
</table>
{!! $package_data->links() !!}
