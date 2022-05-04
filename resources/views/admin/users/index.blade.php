@extends('layouts.admin')
@section('content')
@can('user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        </div>
    </div>
@endcan

@if(Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ Session::get('success') }}
      @php
          Session::forget('success');
      @endphp
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" class="fa fa-times"></span>
      </button>
  </div>
  @endif

<div class="card">
    <div class="card-header">
        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.user.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.first_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.last_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.user.fields.email_verified_at') }}
                    </th> --}}
                    <th>
                        {{ trans('cruds.user.fields.roles') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>



$(document).on('click', '.userDeclined', function(event) {

if(confirm("Are you sure you want to delete this user?")){
    return true;
}
else{
    return false;
}
});

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.users.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.users.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
    { data: 'id', name: 'id' },
    { data: 'first_name', name: 'first_name' },
    { data: 'last_name', name: 'last_name' },
    { data: 'email', name: 'email' },
    // { data: 'email_verified_at', name: 'email_verified_at' },
    { data: 'roles', name: 'roles.title' },
    { data: 'status', name: 'status' },
    { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
    "fnDrawCallback": function() {
            $('.chkToggle').bootstrapToggle();
        },
  };

  let table = $('.datatable-User').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

  
});

$(document).on('change', '.chkToggle', function(event) {

    var $this = $(this);
    var state = $this.prop('checked');
    var userID = $this.attr('userID');

    if(confirm("Are you sure you want to change this user status?")){
        window.location.href = "{{ url('') }}/userApproval/"+userID;
    }
    else{
        $this.prop('checked', !state).bootstrapToggle('destroy').bootstrapToggle();
    }
});

</script>
@endsection