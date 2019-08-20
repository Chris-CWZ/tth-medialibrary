$().ready(function(){
  var $table = $('#bootstrap-table');
  var url = $table.data('url');

  window.operateEvents = {
    'click .view': function(e, value, row, index) {
      location.href = url + '/' + row.id;
    },
    'click .edit': function(e, value, row, index) {
      location.href = url + '/' + row.id + '/edit';
    },
    'click .remove': function(e, value, row, index) {
			swal({
        title: "Are you sure?",
        text: "This action can not be recovered!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-danger btn-fill",
        confirmButtonText: "Yes, delete it!",
        cancelButtonClass: "btn btn-primary btn-fill",
        closeOnConfirm: true,
	    }, function() {
				$table.bootstrapTable('remove', {
	        field: 'id',
	        values: [row.id]
	      });
				$.ajax({
	        type: "delete",
	        url: url + '/' + row.id,
	        contentType: 'application/json',
	        dataType: 'json',
	        success: function(res) {
	          swal("Deleted!", "The row has been deleted.", "success");
	        },
	        error: function(res) {
	          console.log("ERR" , res);
	        },
	        complete: function() {
	          console.log();
	        }
	      });
	    });
    }
  };

  $table.bootstrapTable({
      toolbar: ".toolbar",
      clickToSelect: true,
      showRefresh: true,
      search: true,
      showToggle: false,
      showColumns: false,
      pagination: true,
      searchAlign: 'left',
      toolbarAlign: 'right',
      pageSize: 10,
      sidePagination: 'server',
      clickToSelect: false,
      formatShowingRows: function(pageFrom, pageTo, totalRows) {
          //do nothing here, we don't want to show the text "showing x of y from..."
      },
      formatRecordsPerPage: function(pageNumber) {
          return pageNumber + " rows visible";
      },
      icons: {
          refresh: 'fa fa-refresh',
          toggle: 'fa fa-th-list',
          columns: 'fa fa-columns',
          detailOpen: 'fa fa-plus-circle',
          detailClose: 'fa fa-minus-circle'
      },
      onPostBody: function(data) {
        $('td.tribe-icon').each(function() {
          var td = $(this);
          var cellText = td.html();
          td.html(`<img src= '${cellText}' style="height:80px;width:100px;border-radius:50%" class="img-fluid">`);
        });
      }
  });


//activate the tooltips after the data table is initialized
  $('[rel="tooltip"]').tooltip();

  $(window).resize(function() {
      $table.bootstrapTable('resetView');
  });
});
