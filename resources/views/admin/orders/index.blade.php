@extends('layouts.admin.master')

@section('content')
	<div class="card bootstrap-table">
    <div class="card-body table-full-width pl-3 pr-3">
      <div class="toolbar d-flex flex-row">
        <a href="{{ route('admin.orders.index') }}" class="ml-1"></a>
      </div>
      <table id="bootstrap-table" class="table" data-url="{{ route('admin.orders.index') }}">
        <thead>
          <th data-field="id" class="text-center" data-sortable="true">ID</th>
          <th data-field="user_id" data-sortable="true">User ID</th>
          <th data-field="session_id" data-sortable="true">Session ID</th>
          <th data-field="transaction_id">Transaction ID</th>
          <th data-field="grand_total" data-sortable="true">Amount</th>
          <th data-field="status" data-sortable="true">Status</th>
          <th data-field="created_at" data-sortable="true">Date</th>
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
