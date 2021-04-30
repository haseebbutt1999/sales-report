@extends('adminpanel.admin-module.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="row ">

            <div class="col-md-12 pl-3 pt-2">
                <div class="card" style="width: 100%">

                    <div class="card-header" style="background: white;">
                        <div class="row ">

                            <div class="col-md-12 px-3 pt-2">
                                <div class="mailbox-card-header">
                                    <h3>Rules</h3>
                                    <button type="button"  class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#AddRuleModal">Add Rule</button>
                                    {{--                              Modal--}}
                                    <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="AddRuleModal" role="dialog" tabindex="-1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Rule</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form  class="RuleForm" action="{{Route('rule.save')}}" method="post" onsubmit="AddRule(this)" >
                                                    @csrf

                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Name</label>
                                                            <input  value="" name="name" type="text"  class="form-control name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Tag</label>
                                                            <select class="form-control " name="tag" >
                                                                <option value="" selected>Select Product Tag</option>
                                                                @foreach($product_tag as $product)
                                                                        <option class="product-tag" value="{{$product}}">
                                                                            {{--                                                                        @if(isset($product->mailbox->first()->id) && $product->mailbox->first()->id === $mailbox->id) selected @endif>--}}
                                                                           {{$product}}
                                                                        </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Type</label>
                                                            <select class="form-control " name="type" >
                                                                <option value="" selected>Select Product Type</option>
                                                                @foreach($product_type as $product)
                                                                    @if($product->product_type != null)
                                                                        <option class="product-type" value="{{$product->product_type}}">
                                                                            {{--                                                                        @if(isset($product->mailbox->first()->id) && $product->mailbox->first()->id === $mailbox->id) selected @endif>--}}
                                                                            {{$product->product_type}}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Weight</label>
                                                            <input  value="" name="weight" type="text"  class="form-control weight">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Vendor</label>
                                                            <select class="form-control " name="vendor" >
                                                                <option value="" selected>Select Vendor</option>
                                                                @foreach($product_vendor as $product)
                                                                    @if($product->vendor != null)
                                                                        <option class="product-type" value="{{$product->vendor}}">
                                                                            {{--                                                                        @if(isset($product->mailbox->first()->id) && $product->mailbox->first()->id === $mailbox->id) selected @endif>--}}
                                                                            {{$product->vendor}}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
{{--                                                        @dd($collection_title)--}}
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Collection</label>
                                                            <select class="form-control " name="collection_title" >
                                                                <option value="" selected>Select Collection</option>
                                                                @foreach($collection_title as $collection)
                                                                    @if($collection->title != null)
                                                                        <option class="collection-type" value="{{$collection->title}}">
                                                                            {{$collection->title}}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Package</label>
                                                            <select class="form-control " name="package_id" >
                                                                <option value="" selected>Select Mailbox</option>
                                                                @foreach($package_data as $package)
                                                                    <option class="pacakge-title" value="{{$package->id}}">
                                                                        {{--                                                                        @if(isset($product->mailbox->first()->id) && $product->mailbox->first()->id === $mailbox->id) selected @endif>--}}
                                                                        {{$package->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="text-left" style="margin-right: 28pc;" for="#">Mailbox</label>
                                                            <select class="form-control" name="mailbox_id" >
                                                                <option value="" selected>Select Mailbox</option>
                                                                @foreach($mailbox_data as $mailbox)
                                                                    <option class="mailbox-title" value="{{$mailbox->id}}">
                                                                        {{--                                                                        @if(isset($product->mailbox->first()->id) && $product->mailbox->first()->id === $mailbox->id) selected @endif>--}}
                                                                        {{$mailbox->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit"  class="SaveRule btn btn-primary ">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                              Modal End--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::has('delete'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('delete') }}
                            </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @elseif(Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                    @endif
                    <!-- start info box -->
                        <div class="row ">
                            <div class="col-md-12 pl-3 pt-2">
                                <div class="row px-3 append_data" style="overflow-x:auto;">
                                    <table id="datatabled" class="table table-borderless  table-hover  table-class " >
                                        <thead class="border-0 ">
                                        <tr  class="th-tr table-tr text-white text-center" >
                                            <th class="font-weight-bold">Name</th>
                                            <th class="font-weight-bold">Tag</th>
                                            <th class="font-weight-bold">Type</th>
                                            <th class="font-weight-bold">Weight</th>
                                            <th class="font-weight-bold">Vendor</th>
                                            <th class="font-weight-bold">Collection</th>
                                            <th class="font-weight-bold">Package</th>
                                            <th class="font-weight-bold">Mailbox</th>
                                            <th class="font-weight-bold">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody >

                                        @foreach($rule_data as $key=>$rule)
                                            <tr id="myTableRow" class="td-text-center " >
                                                <td>{{$rule->name}}</td>
                                                <td>{{$rule->tag}}</td>
                                                <td>{{$rule->type}}</td>
                                                <td>{{$rule->weight}}</td>
                                                <td>{{$rule->vendor}}</td>
                                                <td>{{$rule->collection_title}}</td>
                                                <?php
                                                    $package = \App\Package::where('id', $rule->package_id)->first();
                                                ?>
                                                <td>
                                                    @if(isset($package))
                                                        {{$package->title}}
                                                    @else
                                                        no package
                                                    @endif
                                                </td>
                                                <td>
                                                    <?php
                                                        $mailbox = \App\Mailbox::where('id', $rule->mailbox_id)->first();
                                                    ?>
                                                    @if(isset($mailbox))
                                                        {{$mailbox->title}}
                                                    @else
                                                        no mailbox
                                                    @endif
                                                </td>
                                                <td class="weight">
                                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#RuleModal{{$key}}" >Edit</button>

{{--                                                        Rule Modal--}}
                                                        <div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="RuleModal{{$key}}" role="dialog" tabindex="-1">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Rule</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
{{--@dd($rule)--}}
                                                                    <form  class="RuleForm" action="{{Route('rule.edit', $rule->id)}}" method="post" onsubmit="RulePackage(this)" >
                                                                        @csrf
{{--                                                                        <input name="package_id" hidden value="{{$package->id}}">--}}

                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Name</label>
                                                                                <input  value="{{$rule->name}}" name="name" type="text"  class="form-control name">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Tag</label>
                                                                                <select class="form-control " name="tag" >
                                                                                    <option value="" selected>Select Product Tag</option>
                                                                                    @foreach($product_tag as $product)
                                                                                            <option class="product-tag" value="{{$product}}"
                                                                                                @if($product ===  $rule->tag ) selected @endif >
                                                                                                {{$product}}
                                                                                            </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
{{--@dd($rule)--}}
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Type</label>
                                                                                <select class="form-control " name="type" >
                                                                                    <option value="" selected>Select Product Type</option>
                                                                                    @foreach($product_type as $product)
                                                                                        @if($product->product_type != null)
                                                                                            <option class="product-type" value="{{$product->product_type}}"
                                                                                                    @if($product->product_type ===  $rule->type ) selected @endif >
                                                                                                {{$product->product_type}}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Weight</label>
                                                                                <input  value="{{$rule->weight}}" name="weight" type="text"  class="form-control weight">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Vendor</label>
                                                                                <select class="form-control " name="vendor" >
                                                                                    <option value="" selected>Select Vendor</option>
                                                                                    @foreach($product_vendor as $product)
                                                                                        @if($product->vendor != null)
                                                                                            <option class="product-type" value="{{$product->vendor}}"
                                                                                                @if($product->vendor ===  $rule->vendor ) selected @endif >
                                                                                                {{$product->vendor}}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Collection</label>
                                                                                <select class="form-control " name="collection_title" >
                                                                                    <option value="" selected>Select Collection</option>
                                                                                    @foreach($collection_title as $collection)
                                                                                        @if($collection->title != null)
                                                                                            <option class="collection-type" value="{{$collection->title}}"
                                                                                                @if($collection->title === $rule->collection_title) selected @endif >
                                                                                                {{$collection->title}}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Package</label>
                                                                                <?php
                                                                                    $package_title = \App\Package::where('id', $rule->package_id)->first();
                                                                                ?>
                                                                                <select class="form-control " name="package_id" >
                                                                                    <option value="" selected>Select Package</option>
                                                                                    @foreach($package_data as $package)
                                                                                        <option class="pacakge-title" value="{{$package->id}}"
                                                                                            @if($rule->package_id === $package->id) selected @endif >
                                                                                            {{$package->title}}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label class="text-left" style="margin-right: 28pc;" for="#">Mailbox</label>
                                                                                <select class="form-control" name="mailbox_id" >
                                                                                    <option value="" selected>Select Mailbox</option>

                                                                                    @foreach($mailbox_data as $mailbox)
                                                                                        <option class="mailbox-title" value="{{$mailbox->id}}"
                                                                                            @if($rule->mailbox_id === $mailbox->id) selected @endif >
                                                                                            {{$mailbox->title}}
                                                                                        </option>yy
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit"  class="SavePackageRule btn btn-primary ">Save</button>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
{{--                                                        Rule Modal End--}}
                                                        <form action="{{Route('rule.delete', $rule->id)}}" method="post">
                                                            @csrf
                                                            <button data-id="{{$rule->id}}" type="submit" class="btn btn-sm btn-danger DeleteBtn">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $rule_data->links() !!}

                                </div>
                            </div>
                        </div>
                        <!-- end info box -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end info box -->
    </div>

@endsection
