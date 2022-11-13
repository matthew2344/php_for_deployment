<div class="main-content">
<?php foreach($staff as $i): ?>
<div class="row">
   <div class="card rounded">
      <div class="card-header d-flex justify-content-between">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <a href="<?= base_url('Admin_staff')?>">Go back</a>
      </div>
      <?php if(isset($_SESSION['Success'])):?>
         <div class="alert alert-success">
            <?= $this->session->flashdata('Success')?>
         </div>
      <?php endif;?>
      <hr>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url('View_staff/'.$i->userID)?>" class="nav-link <?=($this->uri->segment(1)== "View_staff" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "update_status_staff" ) ? 'active' : '' ?>">Staff View</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Edit_staff/'.$i->userID)?>" class="nav-link 
            <?=($this->uri->segment(1)== "Edit_staff" ) ? 'active' : '' ?>
            <?=($this->uri->segment(2)== "update_staff" ) ? 'active' : '' ?>
            "><i class="fa-regular fa-pen-to-square"></i> Edit Staff information</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/insert_face_staff/'.$i->userID)?>" class="nav-link
            <?=(isset($insert_face)) ? 'active' : ''?>
            ">
            <i class="fa-regular fa-face-smile"></i> Insert Face to Database</a></a>
         </li>
      </ul>
<?php endforeach; ?>

