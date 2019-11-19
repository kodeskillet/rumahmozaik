@extends('layouts.app', ['page' => __('Catalog Edit'), 'pageSlug' => 'catalog'])

@section('content')

<div class="row">
    <div class="col-md-8 offset-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{_('Add Catalog')}}</h4>
            </div>
            <form id = "Form">
                <div class="card-body">
                    @include('alerts.success')

                    @csrf
                    <div class="form-group{{ $errors->has('form') ? ' has-danger' : '' }}">
                        <label>{{ _('Nama Catalog') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ _('Nama Catalog') }}">
                        @include('alerts.feedback', ['field' => 'name'])
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-fill btn-primary" id="ajaxSubmit">{{ _('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-8 offset-2">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title mt-0">Catalog List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow: auto;">
                        <table class="table table-hover" style="margin-bottom: 0 !important;">
                            <thead class="">
                                <tr>
                                    <th>Nama</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-responsive" style="overflow-x: auto; max-height: 39vh !important;">
                        <table class="table table-hover">
                            <tbody id="dataContainer">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        {{-- <div class="card">
            <div class="card-header">
                <h5>Daftar Catalog</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="tableCat">
                        <thead>
                            <th>
                                Nama Catalog
                            </th>
                            <th>
                                Action
                            </th>
                        </thead>
                        <tbody>
                            @foreach($catalogs as $catalog)
                                <tr>
                                    <td>{{$catalog->name}}</td>
                                    <form method="POST" action="/catalog/{{$catalog->id}}">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <td><button type="submit" class="btn btn-fill btn-danger delete-catalog" onclick="return confirm('Are you sure?')"><i class="tim-icons icon-simple-delete"></i></button></td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    // data.forEach(data => {
                    // <form method="POST" action="/catalog/{{$catalog->id}}">
                    //                     {{csrf_field()}}
                    //                     {{method_field('DELETE')}}
                    //                     <td><button type="submit" class="btn btn-fill btn-danger delete-catalog" onclick="return confirm('Are you sure?')"><i class="tim-icons icon-simple-delete"></i></button></td>
                    //                 </form>
                // });

    </div>
</div> --}}



{{-- <script src="../../../node_modules/paginationjs/dist/pagination.js"></script> --}}
<script>
    $(document).ready(function(){
        getData();

        $('#ajaxSubmit').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            let name = $("input[name=name]").val();
            $.ajax({
                url: "http://127.0.0.1:8000/api/catalogtype",
                method: 'post',
                data: {
                    name:name
                },
                success: function(){
                    document.getElementById("Form").reset();
                    getData();
                    $.notify({
                        icon: "tim-icons icon-bell-55",
                        message: "New Catalog added."
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

        $("button[id=deletion]").click(function(){
            let value = $("button[id=deletion]").val();
            console.log(value)})
    });

    function getData() {
        $('#dataContainer').html("");

        $.ajax({
            url: `http://127.0.0.1:8000/api/catalogtype`,
            method: 'GET',
            success: (response) => {
                const data = JSON.parse(response);
                data.forEach(function(item){
                    HTML =
                        '<tr>' +
                        '   <td>'+ item.name +'</td>' +
                        '       <td width="50">' +
                        '           <button class="btn btn-danger" id="deletion" value="'+ item.id +'">' +
                        '               <i class="tim-icons icon-trash-simple"></i>' +
                        '           </button>' +
                        '       </td>' +
                        '</tr>';
                    $('#dataContainer').append(HTML);
                });
            }
        });
    }
</script>
@endsection
