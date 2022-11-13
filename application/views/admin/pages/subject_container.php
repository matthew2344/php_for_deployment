<div class="main-content">

<?php foreach($subject as $i): ?>
<div class="row">
   <div class="card rounded">
      <div class="card-header d-flex justify-content-between">
         <h4 class="fw-bold"><?=$title_viewed?></h4>
         <a href="<?=base_url('Admin/manage_subject')?>">go back</a>
      </div>
        <?php if(isset($_SESSION['Success'])):?>
           <div class="alert alert-success">
              <?= $this->session->flashdata('Success')?>
           </div>
        <?php endif;?>
        <hr>
      <ul class="nav nav-tabs">
         <li class="nav-item">
            <a href="<?=base_url('admin/subject_view/'.$i->subjectID)?>" class="nav-link
                <?=(isset($subject_view)) ? "active" : ""?>
            ">
            <i class="fa-solid fa-book"></i> Subject View</a>
         </li>
         <li class="nav-item">
            <a 
            href="<?=base_url('admin/subject_edit/'.$i->subjectID)?>" 
            class="nav-link
            <?=(isset($subject_edit)) ? "active" : ""?>">
            <i class="fa-regular fa-pen-to-square"></i> Edit Subject</a>
         </li>
      </ul>
<?php endforeach; ?>