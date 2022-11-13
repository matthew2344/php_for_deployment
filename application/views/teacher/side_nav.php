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
      <li  class="<?php if($this->uri->segment(1)=="Teacher_profile"){echo "active";}?>">
         <a href="<?=base_url('Teacher_profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
      </li>
      <li  class="<?php if($this->uri->segment(1)=="Teacher_dashboard"){echo "active";}?>">
         <a href="<?=base_url('Teacher_dashboard')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
      </li>
      <div class="small-screen navbar-display">

      </div>
      <li class="">
         <a href="<?=base_url('Teacher/my_attendance')?>"><i class="material-icons">date_range</i><span>My Gatelog</span></a>
      </li>
      <!-- <li class="">
         <a href="<?=base_url('Teacher/my_class')?>"><i class="material-icons">calendar_month</i><span>Class Attendance</span></a>
      </li> -->
      <!-- <li  class="">
         <a href="#"><i class="material-icons">library_books</i><span>Calender</span></a>
      </li> -->
      <li  class="">
         <a href="<?=base_url('Logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
      </li>
   </ul>
</nav>
