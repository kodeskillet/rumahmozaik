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
                        <input type="text" name="productName" class="form-control{{ $errors->has('productName') ? ' is-invalid' : '' }}" placeholder="{{ _('Nama Produk') }}" autocomplete="off">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal" role="dialog" style="z-index:9999; min-height:550px; position: fixed; top: 42%; left: 50%">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Edit Product</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="productName">Product Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="productName" name="productName" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="catalogType">Tipe Produk:</label>
                    <div class="col-sm-10">
                        <select type="text" class="form-control" id="catalogType" name="catalogType">
                            @foreach ($catalog as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="price">Harga:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="price" name="price">
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                    <span class='glyphicon glyphicon-check'></span> Edit
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
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
                    document.getElementById("Form").reset();
                    getData();
                    $.notify({
                        icon: "tim-icons icon-bell-55",
                        message: "New Product added."
                    },{
                        type: type['#f6383b'],
                        timer: 5000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                }
            });
        });
    });

    function deletion(id){
        if(confirm("Are you sure to delete this record ?")){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url: `http://127.0.0.1:8000/api/product/`+id,
                method: 'delete',
                data: id,
                success: function(){
                    getData();
                    $.notify({
                        icon: "tim-icons icon-bell-55",
                        message: "New Product removed."
                    },{
                        type: type['#f6383b'],
                        timer: 5000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                }
            });
        }
    }

    function edit(id){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
        })
        $.ajax({
            url: `http://127.0.0.1:8000/api/product/`+id,
            method: 'GET',
            data: id,
            success: (response) => {
                const data = JSON.parse(response)
                $('#productName').val(data.productName);
                $('#catalogType option[value="'+data.catalogType+'"]').prop('selected', true);
                $('#price').val(data.price);
                $('#editModal').modal('show');
                $('.modal-footer').on('click', '.edit', function(){
                    $.ajax({
                        type: 'PUT',
                        url: 'http://127.0.0.1:8000/api/product',
                        data:{
                            'id': data.id,
                            'productName' : $('#productName').val(),
                            'catalogType' : $('#catalogType').val(),
                            'price' : $('#price').val()
                        },
                        success: function(){
                            location.reload();
                        }
                    })
                })
            }
        })
    }

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
                        '<td><img src="/storage/products/'+ item.picture +'" alt="' + item.name + '" width = "75" height = "75">' + '</td>'+
                        '<td>' + item.productName + '</td>' +
                        '<td>' + item.catalogName.name + '</td>' +
                        '<td>' + item.price + '</td>' +
                        '<td width = "210">' +
                        '   <button class="btn btn-success" id="edit_'+ item.id +'" onclick="edit('+ item.id +')">' +
                        '       <i class="tim-icons icon-pencil"></i>' +
                        '    </button>' +
                        '   <button class="btn btn-danger" id="deletion_'+ item.id +'" onclick="deletion('+ item.id +')">' +
                        '       <i class="tim-icons icon-trash-simple"></i>' +
                        '    </button>' +
                        '</td>' +
                        '</tr>';
                    $('#dataContainer').append(HTML);
                });
            }
        })
    }



    $('#inputGroupFile01').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        fileName = fileName.substring(fileName.lastIndexOf("\\")+1, fileName.length);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })

</script>

@endsection
