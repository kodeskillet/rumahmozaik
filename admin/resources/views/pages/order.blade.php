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

    }
</script>
@endsection
