<div class="wrapper">
         <div class="body-overlay"></div>
         <!-- Sidebar  -->
         <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header bg-dark d-flex flex-wrap">

               <img class="rounded-circle me-2" width="40px" height="40px" src="<?=base_url('uploads/')?><?=$_SESSION['avatar']?>" alt="">
               <h3 class="text-underline text-light mt-2">
                  <span><?=substr($_SESSION['fname'],0,1)?>. <?=$_SESSION['lname']?></span>
               </h3>
               <!-- <h3><i class="fa-solid fa-user"></i> <span>RecogU</span></h3> -->
            </div>
            <ul class="list-unstyled components">
               <li  class="<?php if($this->uri->segment(1)=="Admin_profile"){echo "active";}?>">
                  <a href="<?=base_url('Admin_profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(1)=="Admin_dashboard"){echo "active";}?>">
                  <a href="<?=base_url('Admin_dashboard')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
               </li>
               <li  class="<?=(isset($in_admin)) ? 'active' : '' ?>">
                  <a href="<?=base_url('Admin/admin')?>" class="dashboard"><i class="material-icons">admin_panel_settings</i><span>Admin</span></a>
               </li>
               <li  
                  class="
                  <?= ($this->uri->segment(1)=="Admin_student") ? 'active' : ''?>
                  <?=($this->uri->segment(1)== "Edit_student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(1)== "View_student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(2)== "student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(2)== "search_student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(2)== "add_student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(2)== "create_student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(2)== "update_status_student" ) ? 'active' : '' ?>
                  <?=($this->uri->segment(2)== "update_student" ) ? 'active' : '' ?>
                  "
                  >
                  <a href="<?=base_url('Admin_student')?>" class="dashboard"><i class="material-icons">face</i><span>Students</span></a>
               </li>
               <li 
                class="<?= ($this->uri->segment(1)=="Admin_teacher") ? 'active' : ''?>
                <?=($this->uri->segment(1)== "View_teacher" ) ? 'active' : '' ?>
                <?=($this->uri->segment(1)== "Edit_teacher" ) ? 'active' : '' ?>
                <?=($this->uri->segment(2)== "update_status_teacher" ) ? 'active' : '' ?>
                <?=($this->uri->segment(2)== "search_teacher" ) ? 'active' : '' ?>
                <?=($this->uri->segment(2)== "add_teacher" ) ? 'active' : '' ?>
                <?=($this->uri->segment(2)== "create_teacher" ) ? 'active' : '' ?>
                <?=($this->uri->segment(2)== "update_teacher" ) ? 'active' : '' ?>
                "
                >
                  <a href="<?=base_url('Admin_teacher')?>" class="dashboard"><i class="material-icons">manage_accounts</i><span>Teaching Staff</span></a>
               </li>
               <li  class="<?php if($this->uri->segment(1)=="Admin_staff"){echo "active";}?>">
                  <a href="<?=base_url('Admin_staff')?>" class="dashboard"><i class="material-icons">badge</i><span>Non-Teaching Staff</span></a>
               </li>

               <li class="">
                  <a href="<?=base_url('Admin/manage_section')?>"><i class="material-icons">groups</i><span>Manage Section/Class</span></a>
               </li>
               
               <li>
                  <a href="<?=base_url('Admin/manage_subject')?>"><i class="material-icons">menu_book</i><span>Manage Subjects</span></a>
               </li>

               <li  class="">
                  <a href="<?=base_url('Admin/gate_logs')?>"><i class="material-icons">library_books</i><span>Gate Logs</span></a>
               </li>

               <li  class="">
                  <a href="<?=base_url('Admin/settings')?>"><i class="material-icons">settings</i><span>School Settings</span></a>
               </li>
               
               <!-- <li  class="">
                  <a href="<?=base_url('Admin/gate_logs')?>"><i class="material-icons"><span class="material-symbols-outlined">familiar_face_and_zone</span></i><span>Train Face</span></a>
               </li> -->

               <li  class="">
                  <a href="<?=base_url('Logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
               </li>
            </ul>
         </nav>