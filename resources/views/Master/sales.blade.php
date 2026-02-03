@extends('layouts.app')

@section('content')
<style>
    textarea.auto-grow {
        resize: none;         
        overflow: hidden;      
    }
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2"></div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="card structure-card">
                <div class="card-header">
                    <h6>Sales</h6>

                </div>
                <div class="card-body">
         
                 <form id="salesubmit" method="POST" action="{{ route('sales.store') }}">
                            @csrf

                            <input type="hidden" id="count" name="count">

                            <div class="row">
                            
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">                          
                                            <label for="order_no">Order Number</label>
                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="order_no"   name="order_no" value ="{{ $orderNo }}" readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">                          
                                            <label for="customer_name">Customer</label>
                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="customer_name" name="customer_name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="mob_no">Mob No</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="mob_no" name="mob_no" >

                                    </div>
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="address">Address</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <textarea class="form-control enter-next auto-grow" name="address" id="address"  rows="1"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                            <label for="item_id">Item Name</label>
                                            <font color="#FF0000" size="">*</font>
                                    </div>

                                    <div class="col-sm-8">
                                        <select class="form-control enter-next" id="item_id"    onchange="getItemDetails()">
                                            <option value="">-- Select Item Name --</option>
                                            @foreach ($itemcode as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->item_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                              <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="current_qty">Current Quantity</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="current_qty"  readonly>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="size">Size</label>


                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="size"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="color">Color</label>


                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="color"/>
                                    </div>
                                </div>
                            </div>
                          

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="sale_qty">Sale Qty</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="sale_qty"  oninput="validateSaleQty(); calculateTotal()">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="price">Price</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="price"   oninput="calculateTotal()">

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="total_amount">Total Amount</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="total_amount"  readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        
                                            <label for="status">Status</label>

                                    </div>

                                    <div class="col-sm-8">
                                        <select class="form-control enter-next"  id="status" name="status">
                                            <option >-- Select Status --</option>
                                            <option value="1">Wholesale</option>
                                            <option value="2">Retail</option>

                                        </select>

                                    </div>
                                </div>
                            </div>

                        </div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addtogridFun()">ADD TO GRID</button>
                    </div>
                <div class="table-responsive">
                    <table class="table mt-3" id="itemgrid">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="itemgridbody"></tbody>
                    </table>
                </div>
                    

                    <div class="mt-3 p-2">
                        <input type="hidden" name="action_type" id="action_type" value="save">
                        <button type="button" class="btn btn-sm btn-primary" onclick="checkform('save')">SAVE</button>
                        <button type="button" class="btn btn-sm btn-primary" onclick="checkform('print')">SAVE & PRINT</button>
                    </div>

                 </form>

        </div>
    </div>
</div>
</div>
</div>


@include('script')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
@endsection
