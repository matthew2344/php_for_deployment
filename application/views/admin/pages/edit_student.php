<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><i class="fa-solid fa-gear"></i> Edit Student</h4>
   </div>
   <hr>
   <?php foreach($student as $i):?>
   <?= form_open('Admin/update_student/'.$i->userID)?>
   <div class="row g-3">
      <div class="col-sm-4">
         <label for="" class="form-label">First name <span class="text-danger">*</span></label>
         <input type="text" name="fname" value="<?php if(isset($fname)){ echo $fname;}else{echo $i->fname;} ?>" class="form-control <?= (form_error('fname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('fname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Middle name <span class="text-danger">*</span></label>
         <input type="text" name="mname" value="<?php if(isset($mname)){ echo $mname; }else{echo $i->mname;}?>" class="form-control <?= (form_error('mname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('mname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Last name <span class="text-danger">*</span></label>
         <input type="text" name="lname" value="<?php if(isset($lname)){ echo $lname;}else{echo $i->lname;} ?>" class="form-control <?= (form_error('lname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('lname');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Phone Number <span class="text-danger">*</span></label>
         <div class="input-group">
            <span class="input-group-text">+63 (PH)</span>
            <input type="text" name="phone" value="<?php if(isset($phone)){ echo $phone;}else{echo $i->phone;} ?>" class="form-control <?= (form_error('phone')) ? 'is-invalid' : ''?>" placeholder="9123456789">
            <div class="invalid-feedback">
               <?php echo form_error('phone');?>
            </div>
         </div>
      </div>
      <div class="col-sm-3">
         <label for="" class="form-label">Date of Birth <span class="text-danger">*</span></label>
         <input type="date" name="bday" value="<?php if(isset($bday)){ echo $bday;}else{echo $i->bday;} ?>" class="form-control <?= (form_error('bday')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('bday');?>
         </div>
      </div>
      <div class="col-sm-5">
         <label for="" class="form-label">Address <span class="text-danger">*</span></label>
         <input type="text" name="address" value="<?php if(isset($address)){ echo $address;}else{echo $i->address;} ?>" class="form-control <?= (form_error('address')) ? 'is-invalid' : ''?>" placeholder="1234 Salty Springs St.">
         <div class="invalid-feedback">
            <?php echo form_error('address');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Zipcode <span class="text-danger">*</span></label>
         <input type="text" name="zipcode" value="<?php if(isset($zipcode)){ echo $zipcode;}else{echo $i->zipcode;} ?>" class="form-control <?= (form_error('zipcode')) ? 'is-invalid' : ''?>" placeholder="1118">
         <div class="invalid-feedback">
            <?php echo form_error('zipcode');?>
         </div>
      </div>
      <hr>
      <h5 class="fw-bold mb-2">Student Application</h5>
      <div class="col-sm-6">
         <label for="" class="form-label">Applying for  <span class="text-danger"> (Your Grade Level) *</span></label>
         <select name="grade_level" id=""  class="form-select <?= (form_error('grade_level')) ? 'is-invalid' : ''?>">
            <option value="<?=$i->gradelevelID?>"><?=$i->grade_title?></option>
            <?php foreach($gradelevel as $o):?>
               <option value="<?=$o->gradelevelID?>"><?=$o->grade_title?> </option>
            <?php endforeach;?>
         </select>
         <div class="invalid-feedback">
            <?php echo form_error('grade_level');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Previous School <span class="text-danger">*</span></label>
         <input type="text" name="previous_school" value="<?php if(isset($previous_school)){ echo $previous_school;}else{echo $i->school_name;} ?>" id="" class="form-control <?= (form_error('previous_school')) ? 'is-invalid' : ''?>" placeholder="FEU TECH">
         <div class="invalid-feedback">
            <?php echo form_error('previous_school');?>
         </div>
      </div>
      <div class="col-sm-12">
         <label for="" class="form-label">Previous School Address <span class="text-danger">*</span></label>
         <input type="text" name="previous_school_address" value="<?php if(isset($previous_school_address)){ echo $previous_school_address;}else{echo $i->school_address;} ?>" id="" class="form-control <?= (form_error('previous_school_address')) ? 'is-invalid' : ''?>" placeholder="Sampaloc, Manila, Paredes st.">
      </div>
      <hr>
      <h5 class="fw-bold mb-2">Guardian's Information </h5>
      <div class="col-sm-4">
         <label for="" class="form-label">First name <span class="text-danger">*</span></label>
         <input type="text" name="guardian_fname" value="<?php if(isset($guardian_fname)){ echo $guardian_fname;}else{echo $i->g_fname;} ?>" class="form-control <?= (form_error('guardian_fname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_fname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Middle name <span class="text-danger">*</span></label>
         <input type="text" name="guardian_mname" value="<?php if(isset($guardian_mname)){ echo $guardian_mname;}else{echo $i->g_mname;} ?>" class="form-control <?= (form_error('guardian_mname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_mname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Last name <span class="text-danger">*</span></label>
         <input type="text" name="guardian_lname" value="<?php if(isset($guardian_lname)){ echo $guardian_lname;}else{echo $i->g_lname;}?>" class="form-control <?= (form_error('guardian_lname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_lname');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Phone Number <span class="text-danger">*</span></label>
         <div class="input-group">
            <span class="input-group-text">+63 (PH)</span>
            <input type="text" name="guardian_phone" value="<?php if(isset($guardian_phone)){ echo $guardian_phone;}else{echo $i->g_phone;} ?>" class="form-control <?= (form_error('guardian_phone')) ? 'is-invalid' : ''?>" placeholder="9123456789">
            <div class="invalid-feedback">
               <?php echo form_error('guardian_phone');?>
            </div>
         </div>
      </div>
      <input type="submit" value="Apply" class="btn btn-outline-primary mt-5">
   </div>
   <?= form_close()?>
   <hr>
   <div class="row g-3">
      <h4 class="fw-bold"><i class="fa-solid fa-gear"></i> Update Other Info</h4>
      <div class="col-sm-5">
         <?=form_open('Admin/update_student_email/'.$i->userID)?>
         <label for="" class="form-label">Email</label>
         <div class="input-group <?= (form_error('email')) ? 'is-invalid' : ''?>">
            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
            <input type="email" name="email" value="<?php echo $i->email;?>" class="form-control <?= (form_error('email')) ? 'is-invalid' : ''?>" placeholder="you@email.com">
            <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-check"></i></button>
         </div>
         <div class="invalid-feedback">
            <?php echo form_error('email');?>
         </div>
         <?=form_close();?>
      </div>
      <div class="col-sm-4">
         <?=form_open('Admin/update_guardian_email/'.$i->userID)?>
         <label for="" class="form-label">Guardian's Email</label>
         <div class="input-group <?= (form_error('g_email')) ? 'is-invalid' : ''?>">
            <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
            <input type="email" name="g_email" value="<?php echo $i->g_email;?>" class="form-control <?= (form_error('g_email')) ? 'is-invalid' : ''?>" placeholder="you@email.com">
            <button class="btn btn-outline-success"><i class="fa-solid fa-check"></i></button>
         </div>
         <div class="invalid-feedback">
            <?php echo form_error('g_email');?>
         </div>
         <?=form_close();?>
      </div>
      <div class="col-sm-6">
         <?=form_open('Admin/update_student_password/'.$i->userID)?>
         <label for="" class="form-label">User's Password</label>
         <div class="input-group <?= (form_error('password')) ? 'is-invalid' : ''?> <?= (form_error('cpassword')) ? 'is-invalid' : ''?>" id="show_hide_password">
            <a  href="" class="btn btn-dark" aria-hidden="true"><i class="fa-solid fa-eye-slash"></i></a>
            <input type="password" name="password" id="" class="form-control <?= (form_error('password')) ? 'is-invalid' : ''?>" placeholder="New Password">
            <input type="password" name="cpassword" id="" class="form-control <?= (form_error('cpassword')) ? 'is-invalid' : ''?>" placeholder="Confirm Password">
            <button class="btn btn-outline-success"><i class="fa-solid fa-check"></i></button>
         </div>
         <div class="invalid-feedback d-flex">
            <?php echo form_error('password');?>
            <?php echo form_error('cpassword');?>
         </div>
         <?=form_close();?>
      </div>

   </div>
   <?php endforeach;?>
</div>

<script defer>
   $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
   });
</script>

