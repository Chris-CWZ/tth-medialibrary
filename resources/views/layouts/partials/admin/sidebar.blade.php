<div class="sidebar" data-color="blue" data-image="{{ asset('images/sidebar_bg.jpg') }}">

  <div class="logo">
		<a href="{{ route('admin.dashboard') }}" class="simple-text logo-mini">
      TH
    </a>
    <a href="{{ route('admin.dashboard') }}" class="simple-text logo-normal">
      The Techy Hub
    </a>
  </div>

  <div class="sidebar-wrapper">
    <div class="user">
			<div class="info">
      <div class="photo">
        <img src="{{ avatar_picture_url(current_user()->avatar) }}" >
      </div>
			<a data-toggle="collapse" href="#collapseExample" class="collapsed">
				<span>{{ str_limit(current_user()->name, 20) }}</span>
      </a>
			</div>
    </div>

    <ul class="nav">
      <li class="nav-item {{ is_active('admin.dashboard') }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="fa fa-pie-chart text-info"></i>
          <p>Dashboard</p>
        </a>
      </li>
			<li class="nav-item {{ is_active('events') }}">
				<a class="nav-link" href="{{ route('admin.events.index') }}">
					<i class="fa fa-users text-info"></i>
					<p>Events</p>
				</a>
      </li>
      <li class="nav-item {{ is_active('calendars') }}">
				<a class="nav-link" href="{{ route('admin.calendar') }}">
					<i class="fa fa-calendar-o text-info"></i>
					<p>Calendar</p>
				</a>
			</li>
      <li class="nav-item {{ is_active('orders') }}">
				<a class="nav-link" href="{{ route('admin.orders.index') }}">
					<i class="fa fa-file-text-o text-info"></i>
					<p>Orders</p>
				</a>
      </li>
      <li class="nav-item {{ is_active('directory') }}">
				<a class="nav-link" href="{{ route('admin.directory.index') }}">
					<i class="fa fa-sitemap text-info"></i>
					<p>Directory</p>
				</a>
			</li>
      <li class="nav-item {{ is_active('promotions') }}">
				<a class="nav-link" href="{{ route('admin.promotions.index') }}">
					<i class="fa fa-usd text-info"></i>
					<p>Promotions</p>
				</a>
      </li>

      <li class="nav-item {{ is_active('discoverables') }}">
				<a class="nav-link" href="{{ route('admin.discoverables.index') }}">
					<i class="fa fa fa-search text-info"></i>
					<p>Discoverables</p>
				</a>
      </li>
      
      <li class="nav-item {{ is_active('explorer') }}">
        <a class="nav-link" href="{{ route('explorers.index') }}">
          <i class="fa fa-image text-info"></i>
          <p>Media Library</p>
        </a>
      </li>
    </ul>
  </div>
</div>
