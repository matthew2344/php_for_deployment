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
      <li  class="<?php if($this->uri->segment(1)=="Student_profile"){echo "active";}?>">
         <a href="<?=base_url('Student_profile')?>" class="dashboard"><i class="material-icons">account_circle</i><span>Profile</span></a>
      </li>
      <li  class="<?php if($this->uri->segment(1)=="Student_dashboard"){echo "active";}?>">
         <a href="<?=base_url('Student_dashboard')?>" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
      </li>

      <li class="">
         <a href="<?=base_url('Student/my_attendance')?>"><i class="material-icons">date_range</i><span>My Gatelogs</span></a>
      </li>
      <!-- <li  class="">
         <a href="#"><i class="material-icons">library_books</i><span>View Gate Logs</span></a>
      </li> -->
      <li  class="">
         <a href="<?=base_url('Logout')?>"><i class="material-icons">logout</i><span>Logout</span></a>
      </li>
   </ul>
</nav>
