<!-- Page Content  -->
<div id="content">
<div class="top-navbar bg-light">
   <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
         <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
         <span class="material-icons">arrow_back_ios</span>
         </button>
         <a class="navbar-brand text-dark" href="#"> Dashboard </a>
         <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="material-icons text-dark">more_vert</span>
         </button>
         <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none" id="navbarSupportedContent">
            <ul class="nav navbar-nav me-auto">
            </ul>
            <ul class="nav navbar-nav">
               <li class="dropdown nav-item">
                  <a href="#" class="nav-link" data-toggle="dropdown">
                  <span class="material-icons text-dark">menu</span>
                  </a>
                  <ul class="dropdown-menu ">
                     <li>
                        <a href="<?=base_url('Student_profile')?>" class="list-group-item">Profile</a>
                     </li>
                     <li>
                        <a href="<?=base_url('Student_edit')?>" class="list-group-item">Settings</a>
                     </li>
                     <li>
                        <a href="<?=base_url('Student')?>" class="list-group-item">Dashboard</a>
                     </li>
                     <li>
                        <a href="<?=base_url('Logout')?>" class="list-group-item">Logout</a>
                     </li>
                  </ul>
               </li>
            </ul>
         </div>
      </div>
   </nav>
</div>
