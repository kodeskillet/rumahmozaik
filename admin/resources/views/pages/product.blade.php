@extends('layouts.app', ['page' => __('Product Edit'), 'pageSlug' => 'product'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Edit Product') }}</h5>
            </div>
            <form method = "post" action="http://localhost:8000/api/product"></form>
        </div>
    </div>
</div>

@endsection
