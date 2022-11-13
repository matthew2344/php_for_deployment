<div class="main-content">
<div class="row">
   <div class="card">
      <div class="card-header">
         <h4 class="fw-bold">My Profile</h4>
         <?php if(validation_errors()): ?>
         <div class="alert alert-danger">
            <?= validation_errors(); ?>
         </div>
         <?php endif; ?>
         <?php if(isset($_SESSION['incorrect'])):?>
         <div class="alert alert-danger">
            <?= $_SESSION['incorrect']; ?>
         </div>
         <?php endif; ?>
      </div>
      <div class="card-body">
         <div class="card bg-light py-3 px-3 mb-5">
            <div class="row">
               <div class="card-title d-flex flex-wrap justify-content-between">
                  Admin Profile
                  <br>
                  <a href="<?= base_url('Student_profile')?>">Go back</a>
               </div>
               <div class="card-body">
                  <?= form_open('Student_update/'.$_SESSION['uid'], array('class' => 'form')) ?>
                  <div class="row mb-5">
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="firstname">First name</label>
                        <input type="text" name="fname" class="form-control" value="<?=$_SESSION['fname']?>">
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="middlename">Middle name</label>
                        <input type="text" name="mname" class="form-control" value="<?=$_SESSION['mname']?>">
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lname" class="form-control" value="<?=$_SESSION['lname']?>">
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                  <?= form_close(); ?>
               </div>
            </div>
         </div>
         <div class="card bg-light py-3 px-3">
            <div class="row">
               <div class="card-title d-flex flex-wrap">
                  Change Password
                  <br>
               </div>
               <div class="card-body">
                  <?= form_open('Student_password/'.$_SESSION['uid'], array('class' => 'form')) ?>
                  <div class="row mb-5">
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="Old password">Old Password</label>
                        <input type="password" name="oldpassword" class="form-control">
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-5 col-sm-3">
                        <label for="Confirm Password">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control">
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                  <?= form_close(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End -->
