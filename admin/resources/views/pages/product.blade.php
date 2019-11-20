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
                        {{-- <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile02" name="picture">
                            <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                        </div> --}}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="inputGroupFile01" name="picture">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
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
                <h3>Daftar Product</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="tableCat">
                        <thead>
                            <th>
                                Foto Product
                            </th>
                            <th>
                                Nama Product
                            </th>
                            <th>
                                Jenis Product
                            </th>
                            <th>
                                Harga
                            </th>
                            <th>
                                Action
                            </th>
                        </thead>
                        <tbody id="dataContainer">
                            {{-- @foreach($products as $product)
                                <tr>
                                    <td><img src="{{asset('/storage/products').'/'.$product->picture}}" alt="{{$product->productName}}" width="75" height="75"></td>
                                    <td>{{$product->productName}}</td>
                                    <td>{{$product->catalogName->name}}</td>
                                    <td>{{$product->price}}</td>
                                    <form method="POST" action="/product/{{$product->id}}">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <td><button type="submit" class="btn btn-fill btn-danger delete-catalog" onclick="return confirm('Are you sure?')"><i class="tim-icons icon-simple-delete"></i></button></td>
                                    </form>
                                </tr>
                            @endforeach
                            var_dump($products) --}}
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>


<script>
    jQuery(document).ready(function(){
        getData();
        jQuery('#ajaxSubmit').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var form = document.getElementById('Form');
            var formData = new FormData(form);
            jQuery.ajax({
                url: "http://127.0.0.1:8000/api/product",
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(){
                    form.reset(),
                    location.reload()
                }
            });
        });
    });

    function getData(){
        $('#dataContainer').html("");

        $.ajax({
            url: `http://127.0.0.1:8000/api/product`,
            method: 'get',
            success: (response) => {
                const data = JSON.parse(response);
                data.forEach(function(item){
                    HTML =
                        '<tr>' +
                        '<td> Tes </td>' +
                        // '<td><img src="'+ asset("/storage/products")+ "/" + item.picture +'" alt="' + item.name + '" width = "75" height = "75">' + '</td>'+
                        '<td>' + item.productName + '</td>' +
                        '<td>' + item.catalogName.name + '</td>' +
                        '<td>' + item.price + '</td>' +
                        '<td width="60">' +
                        '   <button class="btn btn-danger" id="deletion_'+ item.id +'>' +
                        '       <i class="tim-icons icon-trash-simple"></i>' +
                        '   </button>' +
                        '</td>' +
                        '</tr>';
                    $('#dataContainer').append(HTML);
                });
            }
        })
    }

    // function getData() {
    //     $('#dataContainer').html("");

    //     $.ajax({
    //         url: `http://127.0.0.1:8000/api/catalogtype`,
    //         method: 'GET',
    //         success: (response) => {
    //             const data = JSON.parse(response);
    //             data.forEach(function(item){
    //                 HTML =
    //                     '<tr>' +
    //                     '   <td>'+ item.name +'</td>' +
    //                     '       <td width="50">' +
    //                     '           <button class="btn btn-danger" id="deletion_'+ item.id +'" onclick="deletion('+ item.id +')">' +
    //                     '               <i class="tim-icons icon-trash-simple"></i>' +
    //                     '           </button>' +
    //                     '       </td>' +
    //                     '</tr>';
    //                 $('#dataContainer').append(HTML);
    //             });
    //         }
    //     });
    // }

    $('#inputGroupFile01').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        fileName = fileName.substring(fileName.lastIndexOf("\\")+1, fileName.length);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })

</script>

@endsection
