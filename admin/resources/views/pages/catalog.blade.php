@extends('layouts.app', ['page' => __('Catalog Edit'), 'pageSlug' => 'catalog'])

@section('content')

<div class="row">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{_('Edit Catalog')}}</h5>
            </div>
            <form id = "Form">
                <div class="card-body">
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
        <div class="card">
            <div class="card-header">
                <h5>Daftar Catalog</h5>
            </div>
            <div class="table-responsive">
                <table class="table" id="tableCat">
                    <thead class="text-primary">
                        <th>
                            ID
                        </th>
                        <th>
                            Nama Catalog
                        </th>
                    </thead>
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
            var name = $("input[name=name").val();
          jQuery.ajax({
             url: "http://127.0.0.1:8000/api/catalogtype",
             method: 'post',
             data: {
                name:name
             },
             success: function(){
                document.getElementById("Form").reset();
             }});
          });
       });

       $(document).ready(function(){
            $.getJSON("http://127.0.0.1:8000/api/catalogtype",function(data){
                var catalog_data = '<tbody>';
                $.each(data, function(key, value){
                    catalog_data += '<tr>';
                    catalog_data += '<td>'+value.id+'</td>';
                    catalog_data += '<td>'+value.name+'</td>';
                    catalog_data += '</tr>';

                });
                catalog_data += '</tbody>';
                // console.log(data);
            });
       });

</script>
@endsection
