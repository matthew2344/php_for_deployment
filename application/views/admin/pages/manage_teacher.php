<div class="main-content">

<div class="row">
   <div class="card rounded">
      <div class="card-header">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <?php if(isset($_SESSION['Success'])):?>
            <div class="alert alert-success">
               <?= $this->session->flashdata('Success')?>
            </div>
         <?php endif;?>
         <hr>
      </div>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url('Admin_teacher')?>" class="nav-link <?=($this->uri->segment(1)== "Admin_teacher" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "search_teacher" ) ? 'active' : '' ?>">Teacher Lists</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/add_teacher')?>" class="nav-link 
               <?=($this->uri->segment(2)== "add_teacher" ) ? 'active' : '' ?> 
               <?=($this->uri->segment(2)== "create_teacher" ) ? 'active' : '' ?>"
               >
               <i class="fa-sharp fa-solid fa-plus"></i> Add New Teacher
            </a>
         </li>
      </ul>


