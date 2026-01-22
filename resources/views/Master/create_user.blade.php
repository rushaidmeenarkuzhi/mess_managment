@extends('layouts.app')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2"></div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="card structure-card">
                    <div class="card-header">
                        <h6>{{ isset($user) ? 'Edit User' : 'ADD NEW USER' }}</h6>
                        
                    </div>
                    <div class="card-body">
                        <form id="saveform" action="{{ isset($user) ? route('user.update',$user->id) :  route('user.store') }}" method="POST">
                            @csrf

                            @if(isset($user))
                              @method('PUT')
                            @endif
                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="name">Name</label>
                                                <font color="#FF0000" size="">*</font>
                                            </div>
    
                                        </div>
    
                                        <div class="col-sm-8">
                                            {{-- <input type="text" class="form-control" id="name" name="name" value=""  required> --}}
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name ?? '')  }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
    
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="password">Password</label>
                                                <font color="#FF0000" size="">*</font>
                                            </div>
    
                                        </div>
    
                                        <div class="col-sm-8">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
    
                                        </div>
                                    </div>

                                   


                                </div>
                                <div class="col-md-6">
                                      <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="username">User Name</label>
                                                <font color="#FF0000" size="">*</font>

                                            </div>
                                            
    
                                        </div>
    
                                        <div class="col-sm-8">
                                            <input id="text" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{  old('username', $user->username ?? '')  }}" required autocomplete="username">

                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
    
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">


                                            <div class="col-sm-4">
                                                <div class="d-flex">
                                                    <label for="confirm_password">Confirm Password</label>
                                                <font color="#FF0000" size="">*</font>

                                                </div>
        
                                            </div>
        
                                            <div class="col-sm-8">
                                                <input id="confirm_password" type="password" class="form-control" name="confirm_password" autocomplete="current-password" required autocomplete="new-password">
                                            </div>
        
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                       <div class="form-group row">
                                            <div class="col-sm-4">
                                                <div class="d-flex">
                                                    <label for="email">Email</label>

                                                </div>
        
                                            </div>
        
                                            <div class="col-sm-8">
                                                <input id="email" type="email" class="form-control" name="email"  value="{{ isset($user->email) }}">
                                            </div>
        
                                    </div>

                                </div>
                                <div class="col-md-6">
                                     <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="d-flex">
                                                <label for="user_type">User Type</label>
                                            </div>
    
                                        </div>
    
                                        <div class="col-sm-8">
                                            <select name="user_type" id="user_type" class="form-select select2" style="width: 100%;">
                                                <option value=""></option>

                                                <option value="1">Administrator</option>
                                                <option value="2">Standard</option>
                                            </select>

    
                                        </div>
                                    </div>



                                   
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <input type="reset" name="Submit2" class="btn btn-default" value="Clear" />

                                </div>
                            </div>
                           
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('script')


<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $('#user_type').select2({
            placeholder: "--Select--",
            allowClear: true
        });
    });
</script>

@endsection
