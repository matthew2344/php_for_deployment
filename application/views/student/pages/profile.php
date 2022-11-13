<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">My Profile</h4>
         <?php if(isset($_SESSION['error'])):?>
         <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
         </div>
         <?php endif; ?>
      </div>
      <hr>
      <div class="card-body">
         <div class="d-flex justify-content-between">
            Student Profile
            <br>
            <a href="<?= base_url('Student_edit')?>">Edit Profile</a>
         </div>
         <div class="row mt-4">
            <div class="col-md-3 pb-2 card shadow rounded">
               <div class="d-flex justify-content-center py-4">
                  <img class="rounded-circle" style="width: 180px; height: 180px;" src="<?=base_url($this->config->item('Upload_img'))?><?=$_SESSION['avatar']?>" alt="" height="200" style="width: inherit; object-fit: contain; display: block;">
               </div>
               <div class="d-flex justify-content-center">
                  <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Change Profile Picture</button>
               </div>
            </div>
            <div class="col-md-9 bg-light py-3">
               <div class="row text-center">
                  <h5><?=$_SESSION['fname'].' '.$_SESSION['mname'].' '.$_SESSION['lname'];?></h5>
                  <hr>
               </div>
               <div class="row">
                  <h5>User ID: <?=$_SESSION['uid']?></h5>
                  <h5>User Type: <?=$_SESSION['role']?></h5>
                  <h5>Email: <?=$_SESSION['email']?></h5>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Avatar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <?= form_open_multipart('Student_avatar/'.$_SESSION['uid']) ?>
            <div class="text-center">
               <h1>
                  <i class="fa-solid fa-upload"></i>
               </h1>
               <br>
               <label for="Upload Profile Picture" class="mb-2">Upload Profile Picture</label>
               <br>
               <input type="file" name="avatar" id="">     
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Save changes</button>
            <?= form_close() ?>
         </div>
      </div>
   </div>
</div>
