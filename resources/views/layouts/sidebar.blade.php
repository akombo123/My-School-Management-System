<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
      <a href="" class="brand-link">
        <span class="brand-text fw-light">MYAPP</span>
      </a>
    </div>
    <div class="sidebar-wrapper">
      <nav class="mt-2">

        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false"
        >
        @if(Auth::user()->user_type == 1)
            <li class="nav-item">
                <a href="{{ url('admin/dashboard') }}" class="nav-link {{ Request::segment(2) =='dashboard' ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-header">Users</li>
            <li class="nav-item">
                <a href="{{ url('admin/admin/list') }}" class="nav-link {{ Request::segment(2) =='admin' ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                <p>Admin</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/student/list') }}" class="nav-link {{ Request::segment(2) =='student' ? 'active' : '' }}">
                    <i class="bi bi-backpack4"></i>
                <p>Students</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/teacher/list') }}" class="nav-link {{ Request::segment(2) =='teacher' ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                <p>Teachers</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/parent/list') }}" class="nav-link {{ Request::segment(2) =='parent' ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                <p>Parents</p>
                </a>
            </li>

            <li class="nav-item {{ (Request::segment(2) =='class'|| Request::segment(2) =='subject'||Request::segment(2) =='assign_subject'||Request::segment(2) =='assign_teacher'||Request::segment(2) =='class_timetable') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='class'|| Request::segment(2) =='subject'||Request::segment(2) =='assign_subject'||Request::segment(2) =='assign_teacher'||Request::segment(2) =='class_timetable') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Academics
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/class/list') }}" class="nav-link {{ Request::segment(2) =='class' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Class</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/subject/list') }}" class="nav-link {{ Request::segment(2) =='subject' ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark"></i>
                    <p>Subjects</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/assign_subject/list') }}" class="nav-link {{ Request::segment(2) =='assign_subject' ? 'active' : '' }}">
                        <i class="bi bi-journal-plus"></i>
                    <p>Assign Subjects</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/assign_teacher/list') }}" class="nav-link {{ Request::segment(2) =='assign_teacher' ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i>
                    <p>Assign Teachers</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/class_timetable/list') }}" class="nav-link {{ Request::segment(2) =='class_timetable' ? 'active' : '' }}">
                        <i class="bi bi-journal-plus"></i>
                    <p>Class Timetable</p>
                    </a>
                </li>

                </ul>
              </li>

              <li class="nav-item {{ (Request::segment(2) =='fees-collection') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='fees-collection') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Fees Collection
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/fees-collection/collect-fees') }}" class="nav-link {{ Request::segment(3) =='collect-fees' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Collect Fees</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/fees-collection/fees-collection-report') }}" class="nav-link {{ Request::segment(3) =='fees-collection-report' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Fee Collection Report</p>
                    </a>
                </li>
                </ul>
              </li>

              <li class="nav-item {{ (Request::segment(2) =='exams') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='exams') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Examinations
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/exams/list') }}" class="nav-link {{ Request::segment(3) =='list' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Exam List</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/exams/exam_schedule') }}" class="nav-link {{ Request::segment(3) =='exam_schedule' ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark"></i>
                    <p>Exam Schedule</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/exams/marks-register') }}" class="nav-link {{ Request::segment(3) =='marks-register' ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark"></i>
                    <p>Marks Register</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/exams/marks-grade') }}" class="nav-link {{ Request::segment(3) =='marks-grade' ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark"></i>
                    <p>Marks Grade</p>
                    </a>
                </li>

                </ul>
              </li>

              <li class="nav-item {{ (Request::segment(2) =='attendance') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='attendance') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Attendance
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/attendance/student') }}" class="nav-link {{ Request::segment(3) =='student' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Student Attendance</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/attendance/report') }}" class="nav-link {{ Request::segment(3) =='report' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Attendance Report</p>
                    </a>
                </li>

                </ul>
              </li>

              <li class="nav-item {{ (Request::segment(2) =='communicate') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='communicate  ') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Communicate
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/communicate/noticeboard') }}" class="nav-link {{ Request::segment(3) =='noticeboard' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Noticeboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/communicate/send-email') }}" class="nav-link {{ Request::segment(3) =='send-email' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Send Email</p>
                    </a>
                </li>
                </ul>
              </li>

              <li class="nav-item {{ (Request::segment(2) =='homework') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='homework  ') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Homework
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/homework/homework') }}" class="nav-link {{ Request::segment(3) =='homework' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Homework List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/homework/homework-report') }}" class="nav-link {{ Request::segment(3) =='homework-report' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Homework Report</p>
                    </a>
                 </li>

                </ul>
              </li>

            <li class="nav-header">System</li>
            <li class="nav-item">
                <a href="{{ url('admin/my-account') }}" class="nav-link {{ Request::segment(2) =='my-account' ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                <p>My Account</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/my-settings') }}" class="nav-link {{ Request::segment(2) =='my-settings' ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                <p>Settings</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/change_password') }}" class="nav-link {{ Request::segment(2) =='change_password' ? 'active' : '' }}">
                    <i class="bi bi-sliders2"></i>
                <p>Change Password</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link {{ Request::segment(2) =='logout' ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-right"></i>
                <p>Logout</p>
                </a>
            </li>


        @elseif(Auth::user()->user_type == 2)
            <li class="nav-item">
                <a href="{{ url('teacher/dashboard') }}" class="nav-link {{ Request::segment(2) =='dashboard' ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('teacher/my-students') }}" class="nav-link {{ Request::segment(2) =='my-students' ? 'active' : '' }}">
                    <i class="bi bi-backpack4"></i>
                <p>My Students</p>
                </a>
            </li>

            <li class="nav-header">My Classes & Subjects</li>
            <li class="nav-item">
                <a href="{{ url('teacher/my-class-subject') }}" class="nav-link {{ Request::segment(2) =='my-class-subject' ? 'active' : '' }}">
                <i class="nav-icon bi bi-palette"></i>
                <p>Classes & Subjects</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('teacher/my-exam-timetable') }}" class="nav-link {{ Request::segment(2) =='my-exam-timetable' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Exam Timetable</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('teacher/marks-register') }}" class="nav-link {{ Request::segment(2) =='marks-register' ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i>
                <p>Marks Register</p>
                </a>
            </li>

            <li class="nav-item {{ (Request::segment(2) =='attendance') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='attendance') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Attendance
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('teacher/attendance/student') }}" class="nav-link {{ Request::segment(3) =='student' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Student Attendance</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('teacher/attendance/report') }}" class="nav-link {{ Request::segment(3) =='report' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Attendance Report</p>
                    </a>
                </li>

                </ul>
              </li>

              <li class="nav-item {{ (Request::segment(2) =='homework') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (Request::segment(2) =='homework  ') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Homework
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('teacher/homework/homework') }}" class="nav-link {{ Request::segment(3) =='homework' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Homework List</p>
                    </a>
                 </li>
                 <li class="nav-item">
                    <a href="{{ url('teacher/homework/homework-report') }}" class="nav-link {{ Request::segment(3) =='homework-report' ? 'active' : '' }}">
                    <i class="bi bi-house-gear"></i>
                    <p>Homework Report</p>
                    </a>
                 </li>

                </ul>
              </li>

            <li class="nav-item">
                <a href="{{ url('teacher/my-calender') }}" class="nav-link {{ Request::segment(2) =='my-calender' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Calender</p>
                </a>
            </li>

            <li class="nav-header">System</li>
            <li class="nav-item">
                <a href="{{ url('teacher/my-account') }}" class="nav-link {{ Request::segment(2) =='my-account' ? 'active' : '' }}">
                <i class="nav-icon bi bi-palette"></i>
                <p>My Account</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('teacher/change_password') }}" class="nav-link {{ Request::segment(2) =='change_password' ? 'active' : '' }}">
                <i class="nav-icon bi bi-palette"></i>
                <p>Change Password</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link {{ Request::segment(2) =='change_password' ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-right"></i>
                <p>Logout</p>
                </a>
            </li>


        @elseif(Auth::user()->user_type == 3)
            <li class="nav-item">
                <a href="{{ url('student/dashboard') }}" class="nav-link {{ Request::segment(2) =='dashboard' ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/fees-collection') }}" class="nav-link {{ Request::segment(2) =='fees-collection' ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Fees Collection</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-subject') }}" class="nav-link {{ Request::segment(2) =='my-subject' ? 'active' : '' }}">
                    <i class="bi bi-book-half"></i>
                <p>My Subjects</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-timetable') }}" class="nav-link {{ Request::segment(2) =='my-timetable' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Class Timetable</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-exam-timetable') }}" class="nav-link {{ Request::segment(2) =='my-exam-timetable' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Exam Timetable</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-calender') }}" class="nav-link {{ Request::segment(2) =='my-calender' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Calender</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/exam-result') }}" class="nav-link {{ Request::segment(2) =='exam-result' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Exam Results</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-homework') }}" class="nav-link {{ Request::segment(2) =='my-homework' ? 'active' : '' }}">
                <i class="bi bi-house-gear"></i>
                <p>My Homework</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/submit-homework') }}" class="nav-link {{ Request::segment(2) =='submit-homework' ? 'active' : '' }}">
                <i class="bi bi-house-gear"></i>
                <p>Submitted Homework</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-attendance') }}" class="nav-link {{ Request::segment(2) =='my-attendance' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Attendance</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('student/my-noticeboard') }}" class="nav-link {{ Request::segment(2) =='my-noticeboard' ? 'active' : '' }}">
                    <i class="bi bi-calendar"></i>
                <p>My Noticeboard</p>
                </a>
            </li>

            <li class="nav-header">System</li>
            <li class="nav-item">
                <a href="{{ url('student/my-account') }}" class="nav-link {{ Request::segment(2) =='my-account' ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                <p>My Account</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('student/change_password') }}" class="nav-link {{ Request::segment(2) =='change_password' ? 'active' : '' }}">
                <i class="nav-icon bi bi-palette"></i>
                <p>Change Password</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link {{ Request::segment(2) =='change_password' ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-right"></i>
                <p>Logout</p>
                </a>
            </li>

        @elseif(Auth::user()->user_type == 4)
            <li class="nav-item">
                <a href="{{ url('parent/dashboard') }}" class="nav-link {{ Request::segment(2) =='dashboard' ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('parent/my-student') }}" class="nav-link {{ Request::segment(2) =='my-student' ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <p>My Student(s)</p>
                </a>
            </li>

            <li class="nav-header">System</li>
            <li class="nav-item">
                <a href="{{ url('parent/my-account') }}" class="nav-link {{ Request::segment(2) =='my-account' ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                <p>My Account</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('parent/change_password') }}" class="nav-link {{ Request::segment(2) =='change_password' ? 'active' : '' }}">
                    <i class="bi bi-sliders2"></i>
                <p>Change Password</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i>
                <p>Logout</p>
                </a>
            </li>
        @endif
        </ul>
      </nav>
    </div>
  </aside>
