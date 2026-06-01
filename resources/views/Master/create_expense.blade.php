@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2"></div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="card structure-card">
                    <div class="card-header d-flex">
                        <h6>{{ isset($expense) ? 'EDIT EXPENSE' : 'ADD EXPENSE' }}</h6>
                        {{-- <button type="button" class="btn btn-primary btn-sm buttonmodal" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            ADD MORE
                        </button> --}}


                    </div>
                    <div class="card-body">
                        <form id="saveform"
                            action="{{ isset($expense) ? route('expense.update', $expense->id) : route('expense.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($expense))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="exp_type">Expense Type</label>
                                                <font color="#FF0000" size="">*</font>
                                            </div>

                                        </div>

                                        <div class="col-sm-8">
                                            {{-- <input type="text" class="form-control enter-next" id="exp_type"
                                                name="exp_type"
                                                value="{{ isset($expense) ? $expense->exp_type : '' }}" required> --}}
                                            <select class="form-control" name="exp_type" id="exp_type" enter-next>
                                                <option value="">--Select Type--</option>
                                                <option value="daily_expense" {{ isset($expense) && $expense->exp_type == 'daily_expense' ? 'selected' : '' }}>Daily Expense</option>
                                                <option value="room_rent" {{ isset($expense) && $expense->exp_type == 'room_rent' ? 'selected' : '' }}>Room Rent</option>
                                                <option value="electrical" {{ isset($expense) && $expense->exp_type == 'electrical' ? 'selected' : '' }}>Electrical</option>
                                                <option value="water" {{ isset($expense) &&$expense->exp_type == 'water' ? 'selected' : '' }}>Water</option>
                                                <option value="internet" {{ isset($expense) && $expense->exp_type == 'internet' ? 'selected' : '' }}>Internet</option>
                                                <option value="other" {{ isset($expense) && $expense->exp_type == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="amount">Amount</label>
                                                <font color="#FF0000" size="">*</font>

                                            </div>

                                        </div>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control enter-next" id="amount"
                                                name="amount" value="{{ isset($expense) ? $expense->amount : '' }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="member_id">Paid By(Member)</label>
                                                <font color="#FF0000" size="">*</font>

                                            </div>

                                        </div>

                                        <div class="col-sm-8">
                                            <select class="form-control" name="paid_by" id="paid_by">
                                                <option value="">Choose Member</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}"
                                                        {{ isset($expense) && $expense->paid_by == $member->id ? 'selected' : '' }}>
                                                        {{ $member->member_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="date">Date</label>
                                                <font color="#FF0000" size="">*</font>

                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control enter-next" id="date"
                                                name="date" value="{{ isset($expense) ? $expense->date : '' }}" required>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="bill_file">Bill Upload</label>
                                            </div>

                                        </div>

                                        <div class="col-sm-8">
                                            <input type="file" class="form-control enter-next" id="bill_file"
                                                name="bill_file" value="{{ isset($expense) ? $expense->bill_file : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="description">Decription</label>
                                            </div>

                                        </div>

                                        <div class="col-sm-8">
                                            <textarea class="form-control enter-next" name="description" id="description" cols="30" rows="1">{{ isset($expense) ? $expense->description : '' }}</textarea>
                                            {{-- <input type="file" class="form-control enter-next" id="description"
                                                name="description" value="{{ isset($expense) ? $expense->description : '' }}"> --}}
                                        </div>
                                    </div>
                                </div>
                            
                                {{-- <div class="col-md-6">
                                    <div class="form-group row">

                                        <div class="modal fade" data-bs-backdrop="static" id="staticBackdrop" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title " id="staticBackdropLabel">ADD ADDITIONAL
                                                            EXPENSE</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            
                                                            <div class="col-sm-2">
                                                                <div class="d-flex">
                                                                    <label for="exp_type">Type</label>
                                                                    <font color="#FF0000" size="">*</font>

                                                                </div>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control enter-next" id="exp_type"
                                                                    name="exp_type"
                                                                    value="{{ isset($expense) ? $expense->exp_type : '' }}" required>

                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="d-flex">
                                                                    <label for="date">Date</label>
                                                                    <font color="#FF0000" size="">*</font>

                                                                </div>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                <input type="date" class="form-control enter-next"
                                                                    id="date" name="date"
                                                                    value="{{ isset($expense) ? $expense->date : '' }}"
                                                                    required>

                                                            </div>
                                                        </div>
                                                         <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <div class="d-flex">
                                                                    <label for="amount">Amount</label>
                                                                    <font color="#FF0000" size="">*</font>

                                                                </div>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control enter-next" id="amount"
                                                                    name="amount" value="{{ isset($expense) ? $expense->amount : '' }}"
                                                                    required>
                                                            </div>
                                                             <div class="col-sm-2">
                                                                <div class="d-flex">
                                                                    <label for="member_id">Paid By(Member)</label>
                                                                    <font color="#FF0000" size="">*</font>

                                                                </div>

                                                              </div>

                                                               <div class="col-sm-4">
                                                                <select class="form-control" name="member_id" id="member_id">
                                                                    <option value="">Choose Member</option>
                                                                    @foreach ($members as $member)
                                                                        <option value="{{ $member->id }}"
                                                                            {{ isset($expense) && $expense->member_id == $member->id ? 'selected' : '' }}>
                                                                            {{ $member->member_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                               </div>
                                                           
                                                            
                                                        </div>
                                                         <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <div class="d-flex">
                                                                    <label for="exp_type">Member</label>
                                                                    <font color="#FF0000" size="">*</font>

                                                                </div>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                 
                                                                 <div class="dropdown">
                                                                    <button class="btn  border dropdown-toggle w-100"  data-bs-toggle="dropdown">
                                                                        Select Members
                                                                    </button>

                                                                    <div class="dropdown-menu p-2" style="width:100%; max-height:250px; overflow:auto;">
                                                                        @foreach ($allmembers as $member)
                                                                            <label class="d-flex align-items-center gap-2">
                                                                                <input type="checkbox" name="member_ids[]" value="{{ $member->id }}">
                                                                                {{ $member->member_name }}
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group row">
                                         <div class="col-sm-4">
                                        <div class="d-flex">
                                            <label for="exp_type">More Expense</label>

                                        </div>

                                        </div>

                                        <div class="col-sm-8">
                                               
                                            <div class="dropdown">
                                                <button class="btn  border dropdown-toggle w-100"  data-bs-toggle="dropdown">
                                                    Select Members
                                                    
                                                </button>

                                                <div class="dropdown-menu p-2" style="width:100%; max-height:250px; overflow:auto;">
                                                         <label class="d-flex align-items-center gap-2 mb-2">
                                                            <input type="checkbox" id="all_members">
                                                            
                                                            All Members</label>

                                                    @foreach ($allmembers as $member)
                                                        <label class="d-flex align-items-center gap-2">
                                                            <input type="checkbox" class="member-checkbox" name="member_ids[]" id="memberId" value="{{ $member->id }}">
                                                            {{ $member->member_name }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                 <input type="hidden" name="status" id="status">
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
   
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
        $(document).ready(function () {

            // $('#memberId').select2({
            //     placeholder: "Choose Members",
            //     dropdownParent: $('#staticBackdrop'),
            //     closeOnSelect: false
            // });

            $('#all_members').on('change', function (){
                $('.member-checkbox').prop(
                    'checked', $(this).prop('checked')
                );
                
            });

        });
</script>
@endsection
