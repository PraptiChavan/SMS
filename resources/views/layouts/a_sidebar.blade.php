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
            <span class="brand-text fw-light">Admin</span>
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
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <!-- Accounts -->
              <li class="nav-item has-treeview {{ request()->routeIs('user.account', 'user.account.create') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ request()->routeIs('user.account', 'user.account.create') ? 'bg-primary text-white' : '' }}">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                          Manage Accounts
                          <i class="fas fa-angle-right"></i>
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('user.account', ['user' => 'counseller']) }}" 
                            class="nav-link {{ request()->routeIs('user.account', 'user.account.create') && request('user') == 'counseller' ? 'bg-white text-black' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Counsellor</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('user.account', ['user' => 'teacher']) }}" 
                            class="nav-link {{ request()->routeIs('user.account', 'user.account.create') && request('user') == 'teacher' ? 'bg-white text-black' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Teachers</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('user.account', ['user' => 'student']) }}" 
                            class="nav-link {{ request()->routeIs('user.account', 'user.account.create') && request('user') == 'student' ? 'bg-white text-black' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Students</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('user.account', ['user' => 'parent']) }}" 
                            class="nav-link {{ request()->routeIs('user.account', 'user.account.create') && request('user') == 'parent' ? 'bg-white text-black' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Parents</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('user.account', ['user' => 'librarian']) }}" 
                            class="nav-link {{ request()->routeIs('user.account', 'user.account.create') && request('user') == 'librarian' ? 'bg-white text-black' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Librarian</p>
                          </a>
                      </li>
                  </ul>
              </li>
              <!-- Manage Classes -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.classes*', 'admin.classes.add') || request()->routeIs('admin.sections*') || request()->routeIs('admin.courses*', 'admin.courses.create') || request()->routeIs('admin.subjects*') ? 'menu-open' : '' }}">
                <a href="#" 
                  class="nav-link" 
                  style="{{ request()->routeIs('admin.classes*', 'admin.classes.add') || request()->routeIs('admin.sections*') || request()->routeIs('admin.courses*', 'admin.courses.create') || request()->routeIs('admin.subjects*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-chalkboard"></i>
                  <p>
                    Manage Classes
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.sections') }}" class="nav-link {{ request()->routeIs('admin.sections') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sections</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.classes') }}" class="nav-link {{ request()->routeIs('admin.classes', 'admin.classes.add') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Classes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.courses') }}" class="nav-link {{ request()->routeIs('admin.courses', 'admin.courses.create') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Courses</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.subjects') }}" class="nav-link {{ request()->routeIs('admin.subjects') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Subjects</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Class Routine -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.periods*') || request()->routeIs('admin.time-table*', 'admin.time-table.create') ? 'menu-open' : '' }}">
                <a href="#" 
                  class="nav-link"
                  style="{{ request()->routeIs('admin.periods*') || request()->routeIs('admin.time-table*', 'admin.time-table.create') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-chalkboard-teacher"></i>
                  <p>
                    Manage Class Routines
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.periods') }}" class="nav-link {{ request()->routeIs('admin.periods') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Periods</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.time-table') }}" class="nav-link {{ request()->routeIs('admin.time-table', 'admin.time-table.create') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Time Table</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Examination -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.examform*', 'admin.examform.create') || request()->routeIs('admin.admitcards*', 'admin.admitcards.create') || request()->routeIs('admin.results*', 'admin.results.create') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('admin.examform*', 'admin.examform.create') || request()->routeIs('admin.admitcards*', 'admin.admitcards.create') || request()->routeIs('admin.results*', 'admin.results.create') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p>
                    Manage Examinations
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.examform') }}" class="nav-link {{ request()->routeIs('admin.examform', 'admin.examform.create') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Examination Schedule</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.admitcards') }}" class="nav-link {{ request()->routeIs('admin.admitcards') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Admit Card</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.results') }}" class="nav-link {{ request()->routeIs('admin.results') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Results</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Attendance -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.attendance*') || request()->routeIs('admin.tattendance*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('admin.attendance*') || request()->routeIs('admin.tattendance*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>
                    Manage Attendance
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>       
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.attendance') }}" class="nav-link {{ request()->routeIs('admin.attendance') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Student Attendance</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.tattendance') }}" class="nav-link {{ request()->routeIs('admin.tattendance') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Teacher Attendance</p>
                    </a>
                  </li>
                </ul>       
              </li>
              <!-- Manage Accountings -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.student-fee*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{request()->routeIs('admin.student-fee*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-money-check"></i>
                  <p>
                    Manage Accountings
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.student-fee') }}" class="nav-link {{ request()->routeIs('admin.student-fee') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Student Fee Details</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- Study Materials -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.studymaterials*', 'admin.studymaterials.create') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('admin.studymaterials*', 'admin.studymaterials.create') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-paste"></i>
                  <p>
                    Study Materials
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>  
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.studymaterials') }}" class="nav-link {{ request()->routeIs('admin.studymaterials', 'admin.studymaterials.create') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Study Materials</p>
                    </a>
                  </li>
                </ul>           
              </li>
              <!-- Event -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.events*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('admin.events*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>
                    Manage Events
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>     
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.events') }}" class="nav-link {{ request()->routeIs('admin.events') ? 'bg-white text-black' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Campus Functions</p>
                    </a>
                  </li>
                </ul>        
              </li>
              <!-- Communication -->
              <li class="nav-item has-treeview {{ request()->routeIs('admin.meetings*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link" style="{{ request()->routeIs('admin.meetings*') ? 'background-color: #007bff; color: white;' : '' }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Communications
                    <i class="fas fa-angle-right"></i>
                  </p>
                </a>    
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.meetings') }}" class="nav-link {{ request()->routeIs('admin.meetings') ? 'bg-white text-black' : '' }}">
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