@extends('layouts.app', ['page' => __('Product Edit'), 'pageSlug' => 'product'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Edit Product') }}</h5>
            </div>
            <form enctype="multipart/form-data" id="Form">
                <div class="card-body">
                    @csrf
                    @method('post')

                    <div class="form-group{{ $errors->has('form') ? ' has-danger' : '' }}">
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
                    <button class="btn btn-fill btn-primary" id="ajaxSubmit">{{ _('Save') }}</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Daftar Product</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="tableCat">
                        <thead>
                            <th>
                                Nama Product
                            </th>
                            <th>
                                Jenis Product
                            </th>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->productName}}</td>
                                    {{-- <form method="POST" action="/catalog/{{$catalog->id}}">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <td><button type="submit" class="btn btn-fill btn-danger delete-catalog" onclick="return confirm('Are you sure?')"><i class="tim-icons icon-simple-delete"></i></button></td>
                                    </form> --}}
                                    <td>{{$product->catalogType}}</td>
                                </tr>
                            @endforeach
                            {{-- var_dump($products) --}}
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>


<script>
    jQuery(document).ready(function(){
       jQuery('#ajaxSubmit').click(function(e){
          e.preventDefault();
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         });
            var productName = $("input[name=productName").val();
            var price = $("input[name=price]").val();
            jQuery.ajax({
             url: "http://127.0.0.1:8000/api/product",
             method: 'post',
             data: {
                productName: productName,
                catalogType: jQuery('#catalogType').val(),
                price: price
             },
             success: function(){
                document.getElementById("Form").reset();
             }});
          });
       });
</script>

@endsection
