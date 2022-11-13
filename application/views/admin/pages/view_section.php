<div class="main-content">

<?php foreach($section_data as $i): ?>
<div class="row">
   <div class="card rounded">
      <div class="card-header d-flex justify-content-between">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <a href="<?=base_url('Admin/manage_section')?>">go back</a>
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
            <a href="<?=base_url("Admin/view_section/$i->sectionID")?>" class="nav-link <?=($this->uri->segment(2)== "view_section" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "student_section") ? 'active' : '' ?> <?=($this->uri->segment(2)== "view_section_search" ) ? 'active' : '' ?>">Section View</a>
         </li>
         <li class="nav-item">
            <a 
            href="<?=base_url("Admin/manage_schedule/$i->sectionID")?>" 
            class="nav-link <?=($this->uri->segment(2)== "manage_schedule" ) ? 'active' : '' ?> 
            <?=($this->uri->segment(2)== "create_section" ) ? 'active' : '' ?>
            <?=($this->uri->segment(2)== "update_section" ) ? 'active' : '' ?> ">
            <i class="fa-regular fa-calendar-days"></i> Manage schedule schema</a>
         </li>
      </ul>
<?php endforeach; ?>

