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
                        <h6>Expense Summary Report</h6>                    
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
                                            <th>Member</th>
                                            <th>Total Amount</th>
                                            <th>Shared</th>
                                            <th>Balance</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                                            
                                                    $data = $master;
                                                    // $grandTotalAmount = 0;
                                                    // $grandShared = 0;
                                                    // $grandBalance = 0;

                                                    // echo $data; exit;    
                                          ?>
                                          @forelse($data as $exps)

                                                 {{-- @php
                                                    $grandTotalAmount += $exps->total_amount;
                                                    $grandShared   += $exps->shared;
                                                    $grandBalance  += $exps->balance;
                                                @endphp --}}
                                                <tr>
                                                    <td align="center" style="width: 20px">

                                                        {{ ++$i }}
                                                    </td>

                                                  
                                                
                                                    <td align="left">
                                                        {{$exps->member_name}}
          
                                                    </td>
                                                   
                                                    <td align="left">
                                                        {{$exps->paid_amount}}
                                                    </td>

                                                   
                                                    <td align="left">
                                                        {{$exps->total_share}}
                            
                                                    </td>
                                                     <td align="left">
                                                        @if($exps->balance > 0)
                                                           <span class="text-success">
                                                              {{ $exps->balance}} Receive
                                                           </span>
                                                        @else
                                                          <span class="text-danger">
                                                            {{ $exps->balance }} Pay
                                                          </span>
                                                        @endif
                                                     </td>
                            
                                                   

                                                </tr>
                                               
                                              @empty

                                              
                                                    <tr>
                                                        <td align="center" colspan="8" style="color: red">No Record Found</td>
                                                    </tr>
                                              @endforelse
                                              
                                    </tbody>

                                    {{-- @if($i > 0) --}}
                                    <tfoot>
                                        <tr style="font-weight: bold; background: #f5ecec;">
                                            <td colspan="2" align="right">GRAND TOTAL</td>

                                            <td>{{ number_format($grandTotal, 2) }}</td>
                                            <td></td>

                                            <td></td>

                                        </tr>
                                    </tfoot>
                                    {{-- @endif --}}
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