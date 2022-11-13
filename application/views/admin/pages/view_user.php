<div class="main-content">
<?php foreach($admin as $i): ?>
<div class="row">
   <div class="card rounded">
      <div class="card-header d-flex justify-content-between">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <a href="<?= base_url($back_url)?>">Go back</a>
      </div>
      <?php if(isset($_SESSION['Success'])):?>
         <div class="alert alert-success">
            <?= $this->session->flashdata('Success')?>
         </div>
      <?php endif;?>
      <hr>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url($view_link)?><?=$i->userID?>" class="nav-link 
            <?=(isset($view_user)) ? 'active' : '' ?> 
            ">
            <?=$view_text?>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url($edit_link)?><?=$i->userID?>" class="nav-link 
                <?=(isset($edit_user)) ? 'active' : '' ?> 
               "
               >
               <i class="fa-regular fa-pen-to-square"></i> <?=$edit_text?>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/insert_face_user/'.$i->userID)?>" class="nav-link
            <?=(isset($insert_face)) ? 'active' : ''?>
            ">
            <i class="fa-regular fa-face-smile"></i> Insert Face to Database</a></a>
         </li>
      </ul>
<?php endforeach; ?>

