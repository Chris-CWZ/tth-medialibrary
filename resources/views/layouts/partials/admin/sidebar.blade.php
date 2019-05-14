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
    </ul>
  </div>
</div>
