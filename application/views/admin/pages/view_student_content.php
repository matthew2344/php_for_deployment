<div class="card-body border border-top-0 mb-2">
    <?php foreach($student as $i):?>
   <div class="row">
      <h4 class="fw-bold"><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></h4>
   </div>
   <hr>
   <h5 class="fw-bold">Detail information</h5>
   <div class="row mb-2">
    <div class="col-sm-6">
        <img class="border" src="<?=base_url("uploads/$i->avatar")?>" alt="" srcset="" style="width: 160px; height:160px;">
    </div>
   </div>
   <div class="row g-2 pt-4">
      <div class="col-sm-6">
         <h5>Student ID: <?=$i->userID?></h5>
      </div>
      <div class="col-sm-6">
         <h5>Student Name: <?=$i->fname?> <?=$i->mname?> <?=$i->lname?></h5>
      </div>
      <div class="col-sm-6">
         <h5>Birth date: <?=$i->bday?></h5>
      </div>
      <div class="col-sm-6">
         <h5>Year/Grade Level: <?=$i->grade_title?></h5>
      </div>
      <div class="col-sm-6 d-flex">
         <h5>Account Status: <span class="<?=($i->status == 0) ? 'text-danger':'text-success'?>"><?=($i->status == 0) ? 'Inactive':'Active'?></span></h5>
         <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" style="padding-left:5px"><i class="fa-regular fa-pen-to-square"></i></a>
      </div>
      <div class="col-sm-6">
         <h5>Email: <?=$i->email?></h5>
      </div>
      <div class="col-sm-6">
         <h5>Phone number: <?=$i->phone?></h5>
      </div>
      <div class="col-sm-6">
        <h5>Address: <?=$i->address?></h5>
      </div>
      <div class="col-sm-6">
        <h5>Zipcode: <?=$i->zipcode?></h5>
      </div>
      <hr>
      <h5 class="fw-bold">Previous School Information</h5>
      <div class="col-sm-6">
        <h5>Previous School: <?=$i->school_name?></h5>
      </div>
      <div class="col-sm-6">
        <h5>Previous School Address: <?=$i->school_address?></h5>
      </div>
      <hr class="mt-4">
      <h5 class="fw-bold">Guardian Information</h5>
      <div class="col-sm-6">
        <h5>Guardian Name: <?=$i->g_fname?> <?=$i->g_mname?> <?=$i->g_lname?></h5>
      </div>
      <div class="col-sm-6">
        <h5>Guardian email: <?=$i->g_email?></h5>
      </div>
      <div class="col-sm-6">
        <h5>Guardian phone number: <?=$i->g_phone?></h5>
      </div>
   </div>
   <hr>
   <?php endforeach;?>
</div>
</div>
</div>



<?php foreach($student as $i):?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Account Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/update_status_student/".$i->userID)?>
      <div class="modal-body">
         <div class="input-group">
            <div class="input-group-text">Account Status</div>
            <select name="status" id="" class="form-select">
               <option value="<?= ($i->status == 0) ? 0 : 1?>"><?= ($i->status == 0) ? 'Inactive' : 'Active'?></option>
               <option value="<?= ($i->status == 0) ? 1 : 0 ?>"><?= ($i->status == 0) ? 'Active' : 'Inactive'?></option>
            </select>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?=form_close();?>
    </div>
    

  </div>

</div>
<?php endforeach;?>