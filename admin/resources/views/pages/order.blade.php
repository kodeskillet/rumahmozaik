@extends('layouts.app', ['page' => __('Order'), 'pageSlug' => 'order'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h3 class="title">Orders</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="orderTable">
                        <thead>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>Order Detail</th>
                            <th>Order Status</th>
                        </thead>
                        <tbody id="dataContainer">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        getData();
    });

    function getData(){
        $('#dataContainer').html("");
        $.ajax({
            url: 'http://127.0.0.1:8000/api/orders',
            method: 'get',
            success: (response) => {
                const data = JSON.parse(response);
                data.forEach(function(item){
                    HTML =
                        '<tr>'+
                        '<td>' + item.name + '</td>' +
                        '<td>' + item.email + '</td>' +
                        '<td>' + item.whatsapp + '</td>' +
                        '<td>' +
                        '   <button type="button" class = "btn btn-success" id = "detailOrder_' + item.id + '" onclick = "detail(' + item.id + ')">Detail</button>'+
                        '</td>' +
                        '<td>' +
                        '   <button type="button" class = "btn btn-warning" id = "state_' + item.id + '" onclick = "state(' + item.id + ')" ' + (item.status == ("SELESAI") ? 'disabled' : '' ) + '>' + item.status + '</button>' +
                        '</td>' +
                        '</tr>';
                        $('#dataContainer').append(HTML);
                });
            }
        })
    }

    function state(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            url: `http://127.0.0.1:8000/api/order/statechange/`+id,
            method: 'post',
            data: id,
            success: function(){
                getData();
                $.notify({
                    icon: "tim-icons icon-bell-55",
                    message: "1 Order done"
                },{
                    type: type['#f6383b'],
                    timer: 5000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                })
            }
        })
    }

    function detail(id){
        $.ajax({
            url: `http://127.0.0.1:8000/api/order/`+id,
            method: "get",
            success: function(){

            }
        })
    }
</script>
@endsection
