@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2"></div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="card structure-card">
                <div class="card-header">
                    <h6>{{ isset($item) ? 'EDIT ITEM' : 'ADD NEW ITEM' }}</h6>

                </div>
                <div class="card-body">
                    <form id="saveform" action="{{ isset($item) ? route('item.update', $item->id) : route('item.store') }}" method="POST">
                        @csrf
                        @if(isset($item))
                        @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="item_name">Item Name</label>
                                            <font color="#FF0000" size="">*</font>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="item_name" name="item_name" value="{{ isset($item) ? $item->item_name : '' }}" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="item_code">Item Code</label>
                                            <font color="#FF0000" size="">*</font>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="item_code" name="item_code" value="{{ isset($item) ? $item->item_code : '' }}" >

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                         <div class="row">
                            
                           
                          
                             {{-- <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="size">Size</label>
                                            <font color="#FF0000" size="">*</font>

                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                          <input type="text" class="form-control" id="size" name="size" value="{{ isset($item) ? $item->size : '' }}" required>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="color">Color</label>
                                            <font color="#FF0000" size="">*</font>

                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                          <input type="text" class="form-control" id="color" name="color" value="{{ isset($item) ? $item->color : '' }}" required>
                                    </div>
                                </div>
                            </div> --}}
                            
                             
                           <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="item_qty">Quantity</label>
                                            <font color="#FF0000" size="">*</font>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="item_qty" name="item_qty" value="{{ isset($item) ? $item->item_qty : '' }}" required onchange="calculateTotal()">

                                    </div>
                                </div>
                            </div>
                         </div>
                         
                               
                            </div>
                           
                            
                            
                            <div class="p-2">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@include('script')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
@endsection