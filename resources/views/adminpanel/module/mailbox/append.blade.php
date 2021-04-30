<table id="datatabled" class="table table-borderless  table-hover  table-class " >
    <thead class="border-0 ">
    <tr class="th-tr table-tr text-white text-center" >
        <th class="font-weight-bold">Title</th>
        <th class="font-weight-bold">Description</th>
        <th class="font-weight-bold">Action</th>
    </tr>
    </thead>
    <tbody >
    @foreach($mailbox_data as $key=>$mailbox)
        <tr id="myTableRow" class="td-text-center">
            <td>{{$mailbox->title}}</td>
            <td>{{$mailbox->description}}</td>
            <td class="text-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#MailboxEditModal{{$key}}" >Edit</button>
                    {{--                              Modal--}}
                    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="MailboxEditModal{{$key}}" role="dialog" tabindex="-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Mail Service</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form  class="EditForm" action="{{Route('edit.mailbox', $mailbox->id)}}" method="post" onsubmit="EditMailbox(this)" >
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="text-left" style="margin-right: 28pc;" for="#">Title</label>
                                            <input placeholder="Title" value="{{$mailbox->title}}" name="title" type="text" required class="form-control edit_title">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-left" style="margin-right: 28pc;" for="#">Description</label>
{{--                                            @dd($mailbox->description)--}}
{{--                                            <input class="form-control" value="{{$mailbox->description}}">--}}
                                            <textarea class="form-control "  name="description" cols="10" required rows="7">{{$mailbox->description}} </textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button"  class="btn btn-primary SaveEditMailbox">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button data-id="{{$mailbox->id}}" type="button" class="btn btn-lg btn-danger DeleteBtn">Delete</button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $mailbox_data->links() !!}
<script type="text/javascript">

    function EditMailbox(element){
        console.log("hit");
        // event.preventDefault();
        // console.log(element);
        console.log($(".edit_title").val())
        // var mailbox_id = element;
        // console.log(package_id);
        $('.modal').modal('hide');

        $.ajax({
            method: "POST",
            url: $(element).attr('action'),
            data: $(element).serialize(),
            dataType:'html',
            success: function (response) {
                console.log(response);

                $('.append_data').html(response);

            },
            error:function(error){
                console.log(error);
                alert("Mailbox Not Edit");
            }
        });
    }

    $(document).ready(function(){
        $(".SaveEditMailbox").on('click',function() {
            EditMailbox($(this).closest('form'));
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
                url: '/delete-mailbox/'+id,
                data: $('.DeletePackage').serialize(),
                success: function (response) {
                    $('.table-box').empty();
                    $('.table-box').append(response);
                    $(button).parents('tr').remove();

                },
                error:function(error){
                    console.log(error);
                }
            });
        });
    });
</script>
