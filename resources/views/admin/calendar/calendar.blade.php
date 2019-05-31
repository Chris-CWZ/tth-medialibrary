@extends('layouts.admin.master')

@section('content')
  <div class="card p-5">
    <div id="calendar"></div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      eventRender: function (event, element, view) {
        $(element).css("margin-top", "10px");
        $(element).css("margin-bottom", "5px");
      },
      eventRender: function(eventObj, $el) {
      $el.popover({
        //title: eventObj.title,
        content: eventObj.discription,
        //end: eventObj.end,
        trigger: 'hover',
        placement: 'top',
        container: 'body'
      });
      },
      eventClick: function(event) {
        window.location.href = 'events/' + event.id + '/edit';
        $(this).css('border-color', 'red');
      },
      selectable: true,
      events: @json($events),
      eventTextColor: 'white',
      eventBackgroundColor: '#F0424B',
      eventLimit: 4,
      displayEventEnd: false,
      displayEventTime: true,
      timeFormat: 'h(:mm)a'
    })
  });
</script>
@endsection
