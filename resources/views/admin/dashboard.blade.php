@extends('admin.layouts.master')
@section('dashboard', 'active')
@section('title') {{ $data['title'] ?? '' }} @endsection

@push('style')
@endpush

@section('content')
<div class="container-xl">
    <div class="content-wrapper">
        <div class="content">
            <div class="card mb-3">
                <div class="row">
                    <div class="col-md-12 d-flex flex-column">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Latest Customers</h4>
                            <a href="{{ route('admin.customer.index') }}"
                                class="btn btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap jsgrid-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">SN</th>
                                            <th width="5%">Image</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Email</th>
                                            <th width="10%">Phone</th>
                                            <th width="10%" class="text-center">Status</th>
                                            <th width="15%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data['customers'] as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> 
                                                    <a href="{{getPhoto($row->image)}}" target="_blank" rel="noopener noreferrer">
                                                        <img src="{{getPhoto($row->image)}}" class="img img-fluid user-image" alt="{{ $row->name }}">
                                                    </a>
                                                </td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ $row->phone }}</td>
                                                <td class="text-center">
                                                    @if ($row->status == 1)
                                                        <span class="badge bg-success text-white">Active</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{-- <a href="{{ route('admin.customer.view', $row->id) }}"
                                                        class="btn btn-info btn-sm"
                                                        data-id="{{ $row->id }}">View</a> --}}
                                                    <a href="{{ route('admin.customer.edit', $row->id) }}"
                                                        class="btn btn-secondary btn-sm"
                                                        data-id="{{ $row->id }}">Edit</a>
                                                    <a href="{{ route('admin.customer.delete', $row->id) }}"
                                                        id="deleteData" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="7">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="row">
                    <div class="col-md-12 d-flex flex-column">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Latest Orders</h4>
                            <a href="{{ route('admin.order.index') }}"
                            class="btn btn-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap jsgrid-table">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Order Number</th>
                                            {{-- <th>Shopping From</th> --}}
                                            <th>Shipping Country</th>
                                            <th>Requested Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data['orders'] as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ str_pad($row->order_number, 2, '0', STR_PAD_LEFT) }}</td>
                                                {{-- <td>{{ $row->shopping_from_country }}</td> --}}
                                                <td>{{ $row->shipping_country }}</td>
                                                <td>{{ $row->created_at }}</td>
                                                <td class="text-center">                                              
                                                    @if ($row->status == 'complete')
                                                        <span class="badge bg-success text-white">Complete</span>
                                                    @elseif ($row->status == 'approved')
                                                        <span class="badge bg-info text-white">Approved</span>
                                                    @elseif ($row->status == 'inprogress')
                                                        <span class="badge bg-info text-white">In Progress</span>
                                                    @elseif ($row->status == 'cancel')
                                                        <span class="badge bg-danger text-white">Cancelled</span>
                                                    @else
                                                        <span class="badge bg-warning text-white">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">

                                                    @if ($row->status != 'incomplete' && $row->status != 'pending' && $row->status != 'cancel')
                                                    <a href="{{ route('order.view', $row->order_id) }}" class="btn btn-info btn-sm" target="_blank"
                                                        data-id="{{ $row->id }}">View</a>
                                                    @endif
                                                    <a href="{{ route('admin.order.edit', $row->id) }}" class="btn btn-secondary btn-sm"
                                                        data-id="{{ $row->id }}">Edit</a>
                                                    @if ($row->status != 'incomplete' && $row->status != 'pending' && $row->status != 'cancel')
                                                        <a href="{{ route('order.invoice', $row->order_id) }}" class="btn btn-primary btn-sm"
                                                            data-id="{{ $row->id }}">Invoice</a>
                                                    @endif
                                                    {{-- <a href="{{ route('admin.country.delete', $row->id) }}"
                                                        id="deleteData" class="btn btn-danger btn-sm">Delete</a> --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="7">No data available</td>
                                            </tr>
                                        @endforelse
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
@endsection

@push('script')
@endpush