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
            <a href="<?=base_url('Admin/admin')?>" class="nav-link 
            <?=(isset($in_admin_list)) ? 'active' : '' ?>
            ">Admin Lists</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/add_admin')?>" class="nav-link 
            <?=(isset($in_admin_add)) ? 'active' : '' ?> 
            "><i class="fa-sharp fa-solid fa-plus"></i> Add New Admin</a>
         </li>
      </ul>


