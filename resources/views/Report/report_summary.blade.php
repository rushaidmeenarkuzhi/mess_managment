@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-10">
            <div class="card structure-card">
                <div class="card-header">
                    <div class="d-flex">
                        <h6>Order Summary Report</h6>                    
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered  table-sm" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Item Name</th>
                                            <th>Item Crrent Qty</th>
                                            <th>Sale Qty</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php

                                                    $itemorder = $master;
                                                     $totalSaleQty = 0;
                                                     $grandTotal = 0;

                                                    // echo $itemorder; exit;    
                                          ?>
                                         @foreach($itemorder as $item)

                                                 @php
                                                    $totalSaleQty += $item->sale_qty;
                                                    $grandTotal   += $item->total_amount;
                                                @endphp
                                                <tr>
                                                    <td align="center" style="width: 20px">

                                                        {{ ++$i }}
                                                    </td>

                                                    <td align="left">
                                                        {{$item->customer_name}}
   
                                                    </td>
                                                
                                                    <td align="left">
                                                        {{$item->item_name}}
          
                                                    </td>
                                                    <td align="left">
                                                        {{$item->item_qty}}
                                                    </td>

                                                    <td align="left">
                                                        {{$item->sale_qty}}
                                                    </td>

                                                   

                                                    <td align="left">
                                                        {{$item->size}}
                            
                                                    </td>
                                                     <td align="left">
                                                        {{$item->color}}
                            
                                                    </td> <td align="left">
                                                        {{$item->price}}
                            
                                                    </td> 
                                                    <td align="left">
                                                        {{$item->status == 1 ? 'Wholesale' : ($item->status ==2 ? 'Retail' : '')}}
                            
                                                    </td>
                                                    <td align="left">
                                                        {{$item->total_amount}}
                            
                                                    </td>

                                                </tr>
                                                @endforeach

                                                    @if($i==0)
                                                    <tr>
                                                        <td align="center" colspan="8" style="color: red">No Record Found</td>
                                                    </tr>
                                              @endif
                                    </tbody>

                                    @if($i > 0)
                                    <tfoot>
                                        <tr style="font-weight: bold; background: #b3a9a9;">
                                            <td colspan="4" align="right">Grand TOTAL</td>

                                            <td>{{ $totalSaleQty }}</td>

                                            <td colspan="4"></td>

                                            <td>{{ number_format($grandTotal, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>
@endsection