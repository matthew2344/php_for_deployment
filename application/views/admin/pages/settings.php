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
            <a href="<?=base_url('admin/settings')?>" class="nav-link
                <?php if(isset($school_setting)) echo "active"?>
            ">
               <i class="fa-solid fa-gear"></i> School Settings
            </a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('admin/calendar')?>" class="nav-link
                <?php if(isset($school_calendar)) echo "active"?>
            ">
               <i class="fa-solid fa-calendar"></i> School Calendar
            </a>
         </li>

      </ul>



