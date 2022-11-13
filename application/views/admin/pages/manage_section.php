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
            <a href="<?=base_url('Admin/manage_section')?>" class="nav-link <?=($this->uri->segment(2)== "manage_section" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "search_section" ) ? 'active' : '' ?>">Section Lists</a>
         </li>
         <li class="nav-item">
            <a href="<?=base_url('Admin/add_section')?>" class="nav-link <?=($this->uri->segment(2)== "add_section" ) ? 'active' : '' ?> <?=($this->uri->segment(2)== "create_section" ) ? 'active' : '' ?>"><i class="fa-sharp fa-solid fa-plus"></i> Add New Section</a>
         </li>
      </ul>


