@extends('layouts.app', ['page' => __('Product Edit'), 'pageSlug' => 'product'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Edit Product') }}</h5>
            </div>
            <form method = "post" action="http://localhost:8000/api/product">
            <div class="card-body">
                @csrf
                <div class="form-group" {{$errors->has('productName') ? 'has-danger' : ''}}>
                    <label>{{'Nama Barang'}}</label>
                    <input
                    type="text"
                    name="productName"
                    class="form-control{{$errors->has('productName')?'is-invalid':''}}"
                    placeholder="{{_('Nama Produk')}}">
                    @include('alerts.feedback', ['field' => 'productName'])
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
