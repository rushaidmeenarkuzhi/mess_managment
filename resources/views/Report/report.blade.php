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
                    <h6>Expense Report</h6>

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
                           
                        <label for="exp_type">Select Expense Type</label>
                        <br>
                                 <select class="form-control mt-1" name="exp_type" id="exp_type">
                                    <option value="">--Select Type--</option>
                                    <option value="daily_expense">Daily Expense</option>
                                    <option value="room_rent" >Room Rent</option>
                                    <option value="electrical">Electrical</option>
                                    <option value="water">Water</option>
                                    <option value="internet">Internet</option>
                                    <option value="other">Other</option>
                                </select>                      
                       </div>
                        
                 </div>
                <div class="col-md-6 form-group">
                   
                       <div class="col-md-12 form-group">
                           
                        <label for="members">Members</label>
                        <br>
                                <select class="form-control enter-next mt-1" id="members" name="members">
                                    <option value="">-- Select Member --</option>
                                    @foreach ($members as $member)
                                    <option value="{{ $member->member_name }}">
                                        {{ $member->member_name }}
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



