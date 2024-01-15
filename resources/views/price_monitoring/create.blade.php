@extends('layouts.app', [
'class' => '',
'elementActive' => 'price_monitoring',
])

@section('content')
<style>
    .material-symbols-outlined {
        font-variation-settings:
            'FILL'0,
            'wght'400,
            'GRAD'0,
            'opsz'48
    }
</style>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card  shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8 create-font">
                            <h3 class="mb-0">{{ __('Price Monitoring') }}</h3>
                        </div>
                        <div class="col text-right add-user">
                            <a href="{{ route('price_monitorings') }}" class="btn btn-sm btn-primary" id="add-user">{{
                                __('Back to list') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
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
                    <form method="post" action="{{ route('price_monitoring.store') }}" autocomplete="off">
                        @csrf
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-first-name">{{ __('Type') }}</label>
                                <input type="text" name="commodities_type" id="input-first-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    required
                                    autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-first-name">{{ __('Item') }}</label>
                                <input type="text" name="commodities_item" id="input-first-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    required
                                    autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-first-name">{{ __('Size (unit)') }}</label>
                                <input type="text" name="commodities_size" id="input-first-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" required
                                    autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-first-name">{{ __('Price') }}</label>
                                <input type="text" name="price" id="price-input"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" required
                                    autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="d-none form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-first-name">{{ __('Attachment') }}</label>
                                <input type="file" name="attachment"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    autofocus>
                            </div>

                            <div class="">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function(){
        $('#price-input').inputmask({
            alias: 'numeric',
            rightAlign: false,
            radixPoint: '.',
            groupSeparator: ',',
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            allowMinus: false,
            // prefix: '$',
            placeholder: '0'
        });
    })
</script>
@endpush