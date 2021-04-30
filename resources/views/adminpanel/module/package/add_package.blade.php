@extends('adminpanel.admin-module.layout.default')
@section('content')
    <div class="col-lg-10 col-md-9 p-4">
        <div class="row pl-3 pt-2 mb-5">
            <div class="custom-col">
            <div class="card">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @elseif(Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="card-header bg-white pb-1">
                    <h5>Add Package</h5>
                </div>
                <div class="card-body">
                    <form action="{{Route('package.save')}}" method="post" >
                        @csrf
                        <div class="form-group">
                            <label for="#">Title</label>
                            <input placeholder="Title" name="title" type="text" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="#">Description</label>
                            <textarea class="form-control" name="description" cols="10" required rows="7"> </textarea>
                        </div>

                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
