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
                    
                  <div class="card-body">
                    <h5 class="card-title">Item Upload</h5>
                 <form action="{{ route('item.fileUpload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class=" row  ">
                        <div class="col-md-8 mb-3">
                            <div class="form-group">

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <strong>{{ $message }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger alert-dismissible">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    </div>
                                @endif
                                    <div class="custom-file">
                                        <input type="file" name="file" required class=" form-control mb-2" >

                                        <span class="mt-2">You can download excel in predefined format by<a href="{{ URL::to( '/exceltemplate/itite_items.xlsx')}}" class="text-primary ">Clicking Here</a></span> 
                                    </div>
                            </div>
                        </div>

                        
                    </div>
                    
                    <input type="submit" name="Submit1" class="btn btn-primary" value="Upload Excel" />

                    <input type="reset" name="Submit2" class="btn btn-default" value="Clear" />
                 
                 </form>




                </div>
                </div>
            </div>
        </div>
    </div>

@include('script')


@endsection
