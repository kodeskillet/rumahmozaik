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
                data.forEach(function(item)){
                    HTML =
                        '<tr>'+
                        '<td>' + item.name + '</td>' +
                        '<td>' + item.email + '</td>' +
                        '<td>' + item.whatsapp + '</td>' +
                        '<td>' +
                        '   <button class = "btn btn-success" id = "detailOrder_' + item.id + '" onclick = "detail('+ item.id +')">Detail</button>'
                        '</td>' +
                        '</tr>'
                }
            }
        })
    }
</script>
@endsection
