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
                    <h6>{{ isset($member) ? 'EDIT MEMBER' : 'ADD NEW MEMBER' }}</h6>

                </div>
                <div class="card-body">
                    <form id="saveform" action="{{ isset($member) ? route('member.update', $member->id) : route('member.store') }}" method="POST">
                        @csrf
                        @if(isset($member))
                        @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="member_name">Name</label>
                                            <font color="#FF0000" size="">*</font>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="member_name" name="member_name" value="{{ isset($member) ? $member->member_name : '' }}" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="address">Address</label>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="address" name="address" value="{{ isset($member) ? $member->address : '' }}" >
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                         <div class="row">
    
                           <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="room_no">Room No</label>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control enter-next" id="room_no" name="room_no" value="{{ isset($member) ? $member->room_no : '' }}">

                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="joining_date">Joining Date</label>
                                            <font color="#FF0000" size="">*</font>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                        <input type="date" class="form-control enter-next" id="joining_date" name="joining_date" value="{{ isset($member) ? $member->joining_date : '' }}" required>

                                    </div>
                                </div>
                            </div>
                         </div>
                         <div class="row">
                               <div class="col-md-6">
                                 <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="status">Status</label>
                                            <font color="#FF0000" size="">*</font>
                                        </div>

                                    </div>

                                    <div class="col-sm-8">
                                         <select class="form-control" name="status" id="status" >
                                             <option value="active">Active</option>
                                             <option value="inactive">Inactive</option>
                                         </select>
                                         
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