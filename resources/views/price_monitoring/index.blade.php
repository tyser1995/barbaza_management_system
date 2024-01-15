@extends('layouts.app', [
'class' => '',
'elementActive' => 'price_monitoring'
])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8 user-font">
                            <h3 class="mb-0">{{ __('Price Monitoring') }}</h3>
                        </div>
                        <div class="col-4 text-right add-user">
                            <a href="{{ route('price_monitoring.create') }}" class="btn btn-sm btn-primary" id="add-user">{{
                                __('Add Price Monitoring') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="tblData" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Type') }}</th>
                                    <th scope="col">{{ __('Item') }}</th>
                                    <th scope="col">{{ __('Size') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th hidden scope="col">{{ __('Attachment') }}</th>
                                    <th scope="col">{{ __('Created Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($price_monitoring as $price_monitorings)
                                    <tr>
                                        <td>{{$price_monitorings->commodities_type}}</td>
                                        <td>{{$price_monitorings->commodities_item}}</td>
                                        <td>{{$price_monitorings->commodities_size}}</td>
                                        <td>{{$price_monitorings->price}}</td>
                                        <td hidden>{{$price_monitorings->attachment}}</td>
                                        <td>{{$price_monitorings->created_at}}</td>
                                        <td>
                                            <a href="{{ route('price_monitoring.edit', $price_monitorings) }}" class="{{Auth::user()->can('price_monitoring-edit') ? 'btn btn-info btn-sm ' : 'btn btn-info btn-sm d-none'}}"><i class="fas fa-pen"></i></a>
                                        </td>
                                        
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
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('#tblData').DataTable();
});
</script>
@endpush
