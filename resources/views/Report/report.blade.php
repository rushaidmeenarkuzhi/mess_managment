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
                    <h6>Order Report</h6>

                </div>
               

        <div class="card-body">

        <form action="{{ route('report.store') }}" method="POST" id="formsubmit">
           @csrf
            <div class="row ">
                <div class="col-md-6 form-group">
                   
                       <div class="col-md-12 form-group">
                           
                           <label for="fromdate">From Date</label>

                           <input type="date" class="form-control mt-2" id="fromdate" name="fromdate"/>
                       </div>
                        
                 </div>

                 <div class="col-md-6 form-group">
          
                         <div class="col-md-12 form-group">
                           
                           <label for="todate">To Date</label>

                           <input type="date" class="form-control mt-2" id="todate" name="todate"/>
                        
                        </div>
                       
                   
                </div>
            </div>

            <div class="row ">
                <div class="col-md-6 form-group">
                   
                       <div class="col-md-12 form-group">
                           
                        <label for="item_id">Items</label>

                                <select class="form-control enter-next" id="item_id" name="item_id">
                                    <option value="">-- Select Item Name --</option>
                                    @foreach ($items as $item)
                                    <option value="{{ $item->item_name }}">
                                        {{ $item->item_name }}
                                    </option>
                                    @endforeach
                                 </select>                        
                       </div>
                        
                 </div>
                  <div class="col-md-6 form-group">
                   
                       <div class="col-md-12 form-group">
                           
                        <label for="customer">Customer</label>

                                <select class="form-control enter-next" id="customer" name="customer">
                                    <option value="">-- Select Item Name --</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_name }}">
                                        {{ $customer->customer_name }}
                                    </option>
                                    @endforeach
                                 </select>                        
                       </div>
                        
                 </div>

               
            </div>


            <div  style="display: flex; justify-content: center;">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-sm btn-primary" name="button" value="1">Summary</button>
                    <button type="submit" class="btn btn-sm btn-success" name="button" value="2">Excel</button>
                </div>
            </div>
            
        </form>
    </div>
    </div>
</div>
</div>
</div>


{{-- @include('script') --}}

@endsection



