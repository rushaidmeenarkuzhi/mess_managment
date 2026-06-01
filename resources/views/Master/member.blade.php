@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-10">
            <div class="card  structure-card">
                <div class="card-header">
                    <div class="d-flex">
                        <h6>Item</h6>
                        <div class="ms-auto">
                            <a href="{{ route('member.create') }}" class="btn btn-sm btn-primary">ADD Member</a>
                        </div>
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
                                            <th>Name</th>
                                            <th>Address</th>
                                            {{-- <th>Room No</th> --}}
                                            <th>Joining Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member )
                                        <tr>
                                            <td align="center" style="width: 20px">{{ ++$i }}</td>
                                            <td align="center" style="width: 20px">{{ $member->member_name }}</td>
                                            <td align="center" style="width: 20px">{{ $member->address }}</td>
                                            {{-- <td align="center" style="width: 20px">{{ $member->room_no }}</td> --}}
                                            <td align="center" style="width: 20px">{{ $member->joining_date }}</td>
                                            <td align="center" style="width: 20px">
                                                @if($member->status == 'active')
                                                    <span class="badge border border-success text-success">
                                                        Active
                                                    </span>
                                                @else
                                                  <span class="badge border border-secondary text-secondary">
                                                     Inactive
                                                  </span>
                                                @endif
                                            </td>
                                            
                                            <div class="btn-group title-quick-actions">
                                                <td width="100px"><a href="{{ route('member.edit', $member->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit text-primary">
                                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                        </svg></a>
                                                    <form id="delete-form-{{ $member->id }}" action="{{ route('member.destroy', $member->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-default act-view" onclick="confirmDelete({{ $member->id }})">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </div>
                                        </tr>
                                        @endforeach
                                    </tbody>
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