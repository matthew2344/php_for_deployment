<div class="main-content">
<?php foreach($student as $i): ?>
<div class="row">
   <div class="card rounded">
      <div class="card-header d-flex justify-content-between">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <a href="<?= base_url('Admin_student')?>">Go back</a>
      </div>
      <?php if(isset($_SESSION['Success'])):?>
         <div class="alert alert-success">
            <?= $this->session->flashdata('Success')?>
         </div>
      <?php endif;?>
      <hr>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url('View_student/'.$i->userID)?>" class="nav-link <?=($this->uri->segment(1)== "View_student" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "update_status_student" ) ? 'active' : '' ?>">Student View</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Edit_student/'.$i->userID)?>" class="nav-link <?=($this->uri->segment(1)== "Edit_student" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "update_student" ) ? 'active' : '' ?>"><i class="fa-regular fa-pen-to-square"></i> Edit student information</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/insert_face_student/'.$i->userID)?>" class="nav-link
            <?=(isset($insert_face)) ? 'active' : ''?>
            ">
            <i class="fa-regular fa-face-smile"></i> Insert Face to Database</a>
         </li>
      </ul>
<?php endforeach; ?>

