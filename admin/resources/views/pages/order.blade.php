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

{{-- Start of modal --}}
<div id="detailModal" class="modal" role="dialog" style="z-index:9999; min-height:550px; position: fixed; top: 42%; left: 50%">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Detail Order</h4>
        </div>
        <div class="modal-body">
            <div class="container" id="modalDataContainer">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </div>
    </div>
</div>
{{-- End of modal --}}

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
                        '   <button type="button" class = "btn btn-warning" id = "state_' + item.id + '" onclick = "state(' + item.id + ')" ' + (item.status == true ? 'disabled' : '' ) + '>' + (item.status == true ? 'Selesai' : 'On Proccess') + '</button>' +
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
        $('#modalDataContainer').html("")

        $.ajax({
            url: `http://127.0.0.1:8000/api/order/`+id,
            method: "get",
            success: function(response){
                const data = JSON.parse(response);
                $('#detailModal').modal('show');
                data.cart.forEach(function(item){
                    HTML =
                        '<p>Nama Product    : ' + item.productName + '</p>' +
                        '<p>Jumlah Product  : ' + item.amount + '</p>' +
                        '<hr>';
                    $('#modalDataContainer').append(HTML);
                })
            }
        })
    }
</script>
@endsection
