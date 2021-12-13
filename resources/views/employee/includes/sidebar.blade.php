<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header text-center">
        Menu
      </li>
      <li class="{{ route('emp.dashboard') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('emp.dashboard') }}">
          <i class="fa fa-chart-line"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="{{ route('emp.punches') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('emp.punches') }}">
          <i class="fa fa-stream"></i> <span>My Punches</span>
        </a>
      </li>
      <li class="{{ route('reports') == url()->current() ? 'active' : ''}}">
        <a href="{{ route('reports') }}">
          <i class="fa fa-lists"></i> <span>My Reports</span>
        </a>
      </li>
    </ul>
  </section>
</aside>