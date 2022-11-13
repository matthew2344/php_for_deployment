<div class="wrapper">
         <div class="body-overlay"></div>
         <!-- Sidebar  -->
         <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header bg-dark">
               <h3><i class="fa-solid fa-user"></i> <span>RecogU</span></h3>
            </div>
            <ul class="list-unstyled components">
               <li  class="<?php if($this->uri->segment(2)=="profile"){echo "active";}?>">
                  <a href="<?=base_url('Admin/profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(2)==""){echo "active";}?>">
                  <a href="<?=base_url('Admin')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(2)=="student"){echo "active";}?>">
                  <a href="<?=base_url('Admin/student')?>" class="dashboard"><i class="material-icons">face</i><span>Students</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(2)=="teacher"){echo "active";}?>">
                  <a href="<?=base_url('Admin/teacher')?>" class="dashboard"><i class="material-icons">manage_accounts</i><span>Teaching Staff</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(2)=="staff"){echo "active";}?>">
                  <a href="<?=base_url('Admin/staff')?>" class="dashboard"><i class="material-icons">badge</i><span>Non-Teaching Staff</span></a>
               </li>
               <div class="small-screen navbar-display">
                  <li class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                     <a href="#homeSubmenu0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                     <i class="material-icons">notifications</i><span> 4 notification</span></a>
                     <ul class="collapse list-unstyled menu" id="homeSubmenu0">
                        <li>
                           <a href="#">You have 5 new messages</a>
                        </li>
                        <li>
                           <a href="#">You're now friend with Mike</a>
                        </li>
                        <li>
                           <a href="#">Wish Mary on her birthday!</a>
                        </li>
                        <li>
                           <a href="#">5 warnings in Server Console</a>
                        </li>
                     </ul>
                  </li>
                  <li  class="d-lg-none d-md-block d-xl-none d-sm-block">
                     <a href="#"><i class="material-icons">apps</i><span>apps</span></a>
                  </li>
                  <li  class="d-lg-none d-md-block d-xl-none d-sm-block">
                     <a href="#"><i class="material-icons">person</i><span>user</span></a>
                  </li>
                  <li  class="d-lg-none d-md-block d-xl-none d-sm-block">
                     <a href="#"><i class="material-icons">settings</i><span>setting</span></a>
                  </li>
               </div>
               <li class="dropdown">
                  <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                  <i class="material-icons">aspect_ratio</i><span>Layouts</span></a>
                  <ul class="collapse list-unstyled menu bg-dark" id="homeSubmenu1">
                     <li>
                        <a href="#">Home 1</a>
                     </li>
                     <li>
                        <a href="#">Home 2</a>
                     </li>
                     <li>
                        <a href="#">Home 3</a>
                     </li>
                  </ul>
               </li>

               <li class="dropdown">
                  <a href="#pageSubmenu6" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                  <i class="material-icons">grid_on</i><span>tables</span></a>
                  <ul class="collapse list-unstyled menu bg-dark" id="pageSubmenu6">
                     <li>
                        <a href="#">Page 1</a>
                     </li>
                     <li>
                        <a href="#">Page 2</a>
                     </li>
                     <li>
                        <a href="#">Page 3</a>
                     </li>
                  </ul>
               </li>
               <li class="">
                  <a href="#"><i class="material-icons">date_range</i><span>copy</span></a>
               </li>
               <li  class="">
                  <a href="#"><i class="material-icons">library_books</i><span>Calender</span></a>
               </li>
               <li  class="">
                  <a href="<?=base_url('Welcome/logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
               </li>
            </ul>
         </nav>