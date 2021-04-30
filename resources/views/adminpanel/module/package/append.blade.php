<table id="datatabled" class="table table-borderless  table-hover  table-class " >
    <thead class="border-0 ">
    <tr  class="th-tr table-tr text-white text-center" >
        <th class="font-weight-bold">Title</th>
        <th class="font-weight-bold">Description</th>
        <th class="font-weight-bold">Action</th>
    </tr>
    </thead>
    <tbody >
    @foreach($package_data as $key=>$package)
        <tr id="myTableRow" class="td-text-center " >
            <td>{{$package->title}}</td>
            <td>{{$package->description}}</td>
            <td class="text-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                    <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#PackageEditModal{{$key}}" >Edit</button>

                    {{--                              Modal--}}
                    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="PackageEditModal{{$key}}" role="dialog" tabindex="-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Package</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form  class="EditForm" action="{{Route('edit.package', $package->id)}}" method="post" onsubmit="EditPackage(this)" >
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="text-left" style="margin-right: 28pc;" for="#">Title</label>
                                            <input placeholder="Title" value="{{$package->title}}" name="title" type="text" required class="form-control edit_title">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" style="margin-right: 28pc;" for="###">Description</label>
                                            <textarea class="form-control " name="description" cols="10" required rows="7">{{$package->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button"  class="btn btn-primary SaveEditPackage">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--                              Modal End--}}
                    {{--                                                        </form>--}}
                    {{--                                                        <form action="{{Route('delete.package', $package->id)}}" method="post">--}}
                    {{--                                                            @csrf--}}
                    <button data-id="{{$package->id}}" type="button" class="btn btn-lg btn-danger DeleteBtn">Delete</button>
                    {{--                                                        </form>--}}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $package_data->links() !!}
<script type="text/javascript">

    function EditPackage(element){

        // event.preventDefault();
        // console.log(element);
        console.log($(".edit_title").val())
        var package_id = element;
        // console.log(package_id);
        $('.modal').modal('hide');

        $.ajax({
            method: "POST",
            url: $(element).attr('action'),
            data: $(element).serialize(),
            dataType:'html',
            success: function (response) {
                console.log(response);
                // $('.append_data').empty();
                $('.append_data').html(response);
                $('.title').val(null);
                $('.description').val(null);
            },
            error:function(error){
                console.log(error);
                alert("Package Not Edit");
            }
        });
    }


    $(document).ready(function(){

        $(".SaveEditPackage").on('click',function() {
            EditPackage($(this).closest('form'));
        });

        $(".DeleteBtn").on('click', function(){
            var id = $(this).attr('data-id');
            var button = this;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: '/delete-package/'+id,
                data: $('.DeletePackage').serialize(),
                success: function (response) {
                    $('.table-box').empty();
                    $('.table-box').append(response);
                    $(button).parents('tr').remove();
                    // alert(' Customer Deleted');
                    //alert("Data Updated");
                },
                error:function(error){
                    console.log(error);
                }
            });
        });
    });
</script>
