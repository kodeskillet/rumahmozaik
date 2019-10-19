@extends('layouts.app', ['page' => __('Product Edit'), 'pageSlug' => 'product'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Edit Product') }}</h5>
            </div>
            <form method = "post" action="http://localhost:8000/api/product" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('post')

                    <div class="form-group{{ $errors->has('productName') ? ' has-danger' : '' }}">
                        <label>{{ _('Nama Produk') }}</label>
                        <input type="text" name="productName" class="form-control{{ $errors->has('productName') ? ' is-invalid' : '' }}" placeholder="{{ _('Nama Produk') }}">
                        @include('alerts.feedback', ['field' => 'product'])

                        <label>{{_('Tipe Produk')}}</label>
                        <select class="form-control" id="catalogType{{ $errors->has('productName') ? ' is-invalid' : '' }}" name="catalogType">
                            <option selected>Choose</option>
                            @foreach ($catalog as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                        <label>{{_('Harga')}}</label>
                        <input type="number" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ _('Harga') }}">
                        @include('alerts.feedback', ['field' => 'price'])

                    </div>
                    {{-- <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                                @include('alerts.feedback', ['field' => 'name']) --}}

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
