<div class="register-section py-5">
   <div class="container">
      <div class="d-flex justify-content-center">
         <div class="col-12">
            <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a href="<?=base_url('Register')?>" class="nav-link <?=($this->uri->segment(2)== "" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "new_student" ) ? 'active' : '' ?>">
                  Student
                  </a>
               </li>
               <li class="nav-item">
                  <a href="<?=base_url('Register/teacher')?>" class="nav-link <?=($this->uri->segment(2)== "teacher") ? 'active' : '' ?> <?=($this->uri->segment(2)== "new_teacher" ) ? 'active' : '' ?>">
                  Teacher
                  </a>
               </li>
               <li class="nav-item">
                    <a href="<?=base_url('Register/staff')?>" class="nav-link <?=($this->uri->segment(2)=="staff") ? 'active' : '' ?> <?=($this->uri->segment(2)== "new_staff" ) ? 'active' : '' ?>">
                        Non-Teaching Staff
                    </a>
               </li>
               <li class="nav-item">
                    <a href="<?=base_url('Register/admin')?>" class="nav-link <?=($this->uri->segment(2)=="admin") ? 'active' : '' ?> <?=($this->uri->segment(2)== "new_admin" ) ? 'active' : '' ?>">
                        Admin
                    </a>
               </li>
            </ul>
            <div class="tab-content border border-top-0 p-3">


