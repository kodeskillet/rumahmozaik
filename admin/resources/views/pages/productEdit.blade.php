@extends('layouts.app', ['page' => __('Product Update'), 'pageSlug' => 'productEdit'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{_('Update Product') }}</h5>
            </div>
            <form enctype="multipart/form-data" id="Form"></form>
            <div class="card-body">
                @csrf
                @method('post')
                <div class="form-group{{ $errors->has('form') ? ' has-danger' : '' }}">
                    <label>{{ _('Nama Produk') }}</label>
                    <input type="text" name="productName" class="form-control{{ $errors->has('productName') ? ' is-invalid' : '' }}" placeholder="{{ _('Nama Produk') }}" value="{{$product->productName}}">
                    @include('alerts.feedback', ['field' => 'product'])

                    <label>{{_('Tipe Produk')}}</label>
                    <select class="form-control" id="catalogType{{ $errors->has('productName') ? ' is-invalid' : '' }}" name="catalogType">
                        <option selected>Choose</option>
                        @foreach ($catalog as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    </select>
                    <label>{{_('Harga')}}</label>
                    <input type="number" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ _('Harga') }}" value="{{$product->price}}">
                    @include('alerts.feedback', ['field' => 'price'])
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="inputGroupFile01" name="picture" value="{{$product->picture}}">
                          <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
