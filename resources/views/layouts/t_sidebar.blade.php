      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <li class="nav-item">
              <a href="{{ url('/logout') }}" class="nav-link">Logout <i class="fa fa-sign-out-alt"></i></a>
              <!-- <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="nav-item">Logout<i class="fa fa-sign-out-alt"></i></button>
              </form> -->
            </li>
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ url('/dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assets\img\admin\AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Teacher</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false">
              <!-- Dashboard -->
              <li class="nav-item menu-open">
                <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'bg-primary text-white' : '' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <!-- Manage Classes -->
              <li class="nav-item has-treeview {{ request()->routeIs('teacher.courses*') || request()->routeIs('teacher.subjects*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('teacher.courses*') || request()->routeIs('teacher.subjects*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-chalkboard"></i>
                  <p>
                    Manage Classes
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('teacher.courses') }}" class="nav-link {{ request()->routeIs('teacher.courses') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Courses</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('teacher.subjects') }}" class="nav-link {{ request()->routeIs('teacher.subjects') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Subjects</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Class Routine -->
              <li class="nav-item has-treeview {{ request()->routeIs('teacher.periods*') || request()->routeIs('teacher.time-table*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('teacher.periods*') || request()->routeIs('teacher.time-table*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-chalkboard-teacher"></i>
                  <p>
                    Manage Class Routines
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('teacher.periods') }}" class="nav-link {{ request()->routeIs('teacher.periods') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Periods</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('teacher.time-table') }}" class="nav-link {{ request()->routeIs('teacher.time-table') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Time Table</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Examination -->
              <li class="nav-item has-treeview {{ request()->routeIs('teacher.examform*') || request()->routeIs('teacher.results*', 'teacher.results.create') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('teacher.examform*') || request()->routeIs('teacher.results*', 'teacher.results.create') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p>
                    Manage Examinations
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('teacher.examform') }}" class="nav-link {{ request()->routeIs('teacher.examform') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Examination Schedule</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('teacher.results') }}" class="nav-link {{ request()->routeIs('teacher.results') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Results</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Attendance -->
              <li class="nav-item has-treeview {{ request()->routeIs('teacher.attendance*') || request()->routeIs('teacher.my_attendance*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('teacher.attendance*') || request()->routeIs('teacher.my_attendance*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>
                    Manage Attendance
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>       
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('teacher.attendance') }}" class="nav-link {{ request()->routeIs('teacher.attendance') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Student Attendance</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('teacher.my_attendance') }}" class="nav-link {{ request()->routeIs('teacher.my_attendance') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>My Attendance</p>
                    </a>
                  </li>
                </ul>       
              </li>
              <!-- Study Materials -->
              <li class="nav-item has-treeview{{ request()->routeIs('teacher.studymaterials*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('teacher.studymaterials*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-paste"></i>
                  <p>
                    Study Materials
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>  
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('teacher.studymaterials') }}" class="nav-link {{ request()->routeIs('teacher.studymaterials') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Study Materials</p>
                    </a>
                  </li>
                </ul>           
              </li>
              <!-- Communication -->
              <li class="nav-item has-treeview{{ request()->routeIs('teacher.meetings*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('teacher.meetings*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Communications
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>    
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('teacher.meetings') }}" class="nav-link {{ request()->routeIs('teacher.meetings') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Parent's Meetings</p>
                    </a>
                  </li>
                </ul>          
              </li>
            </ul>    
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->