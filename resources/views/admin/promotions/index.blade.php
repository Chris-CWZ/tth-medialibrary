@extends('layouts.admin.master')

@section('content')
	<div class="card bootstrap-table">
    <div class="card-body table-full-width pl-3 pr-3">
      <div class="toolbar mt-2">
        <a href="{{ route('admin.promotions.create') }}">
          <button class="btn"><i class="fa fa-plus"></i></button>
        </a>
      </div>
      <table id="bootstrap-table" class="table" data-url="{{ route('admin.promotions.index') }}">
        <thead>
          <th data-field="id" class="text-center" data-sortable="true">ID</th>
          <th data-field="code" data-sortable="true">Promo code</th>
          <th data-field="type" data-sortable="true">Type</th>
          <th data-field="start_date">Start date</th>
          <th data-field="expiry_date" data-sortable="true">Expiry date</th>
          <th data-field="actions" class="td-actions text-right" data-events="operateEvents" data-formatter="operateFormatter">Actions</th>
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    function operateFormatter(value, row, index) {
      return [
        '<a rel="tooltip" title="View" class="btn btn-link btn-primary table-action view" href="javascript:void(0)">',
        '<i class="fa fa-user-circle"></i>',
        '</a>',
        '<a rel="tooltip" title="Edit" class="btn btn-link btn-warning table-action edit" href="javascript:void(0)">',
        '<i class="fa fa-edit"></i>',
        '</a>',
		'<a rel="tooltip" title="Remove" class="btn btn-link btn-danger table-action remove" href="javascript:void(0)">',
        '<i class="fa fa-remove"></i>',
        '</a>'
      ].join('');
    }
  </script>
@endsection
