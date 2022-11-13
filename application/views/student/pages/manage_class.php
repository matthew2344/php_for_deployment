<div class="main-content">

<div class="row">
   <div class="card rounded">
      <div class="card-header">
         <div class="text-truncate">
            <h4 class="fw-bold"><?=$title_viewed?></h4>
         </div>
         <?php if(isset($_SESSION['Danger'])):?>
            <div class="alert alert-danger">
               <?= $this->session->flashdata('Danger')?>
            </div>
         <?php endif;?>
         <?php if(isset($_SESSION['Success'])):?>
            <div class="alert alert-success">
               <?= $this->session->flashdata('Success')?>
            </div>
         <?php endif;?>
         <hr>
      </div>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url('student/this_class/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>" class="nav-link
            <?=(isset($view_subject)) ? 'active' : '' ?>
            ">
                <i class="fa-solid fa-book"></i> My Subject
            </a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('student/this_class_attendance/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>" class="nav-link
            <?=(isset($subject_attendance)) ? 'active' : '' ?>
            ">
            <i class="fa-solid fa-calendar-check"></i> My Attendance
            </a>
         </li>
      </ul>


