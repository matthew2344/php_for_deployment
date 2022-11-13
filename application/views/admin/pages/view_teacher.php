<div class="main-content">
<?php foreach($teacher as $i): ?>
<div class="row">
   <div class="card rounded">
      <div class="card-header d-flex justify-content-between">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <a href="<?= base_url('Admin_teacher')?>">Go back</a>
      </div>
      <?php if(isset($_SESSION['Success'])):?>
         <div class="alert alert-success">
            <?= $this->session->flashdata('Success')?>
         </div>
      <?php endif;?>
      <?php if(isset($_SESSION['time_error'])):?>
           <div class="alert alert-danger">
              <?= $this->session->flashdata('time_error')?>
           </div>
      <?php endif;?>
      <hr>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url('View_teacher/'.$i->userID)?>" class="nav-link <?=($this->uri->segment(1)== "View_teacher" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "update_status_teacher" ) ? 'active' : '' ?>">Teacher View</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Edit_teacher/'.$i->userID)?>" class="nav-link 
               <?=($this->uri->segment(1)== "Edit_teacher" ) ? 'active' : '' ?>
               <?=($this->uri->segment(2)== "update_teacher" ) ? 'active' : '' ?>
               "
               >
               <i class="fa-regular fa-pen-to-square"></i> Edit teacher information
            </a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/insert_face_teacher/'.$i->userID)?>" class="nav-link
            <?=(isset($insert_face)) ? 'active' : ''?>
            ">
            <i class="fa-regular fa-face-smile"></i> Insert Face to Database</a></a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/add_subject_teaching/'.$i->userID)?>" class="nav-link
            <?=(isset($add_teaching)) ? 'active' : ''?>
            ">
               <i class="fa-sharp fa-solid fa-plus"></i> Add Subject to teach
            </a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/subject_teaching/'.$i->userID)?>" class="nav-link
            <?=(isset($subject_teaching)) ? 'active' : ''?>
            ">
               <i class="fa-solid fa-chalkboard-user"></i> Teaching Subjects
            </a>
         </li>
      </ul>
<?php endforeach; ?>

