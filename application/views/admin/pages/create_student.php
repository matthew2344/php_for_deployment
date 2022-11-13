<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold">Create Student</h4>
   </div>
   <hr>
   <?= form_open('Admin/create_student')?>
   <div class="row g-3">
      <div class="col-sm-4">
         <label for="" class="form-label">First name <span class="text-danger">*</span></label>
         <input type="text" name="fname" value="<?php if(isset($fname)) echo $fname ?>" class="form-control <?= (form_error('fname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('fname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Middle name <span class="text-danger">*</span></label>
         <input type="text" name="mname" value="<?php if(isset($mname)) echo $mname ?>" class="form-control <?= (form_error('mname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('mname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Last name <span class="text-danger">*</span></label>
         <input type="text" name="lname" value="<?php if(isset($lname)) echo $lname ?>" class="form-control <?= (form_error('lname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('lname');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Email <span class="text-danger">*</span></label>
         <input type="email" name="email" value="<?php if(isset($email)) echo $email ?>" class="form-control <?= (form_error('email')) ? 'is-invalid' : ''?>" placeholder="you@email.com">
         <div class="invalid-feedback">
            <?php echo form_error('email');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Phone Number <span class="text-danger">*</span></label>
         <div class="input-group">
            <span class="input-group-text">+63 (PH)</span>
            <input type="text" name="phone" value="<?php if(isset($phone)) echo $phone ?>" class="form-control <?= (form_error('phone')) ? 'is-invalid' : ''?>" placeholder="9123456789">
            <div class="invalid-feedback">
               <?php echo form_error('phone');?>
            </div>
         </div>
      </div>
      <div class="col-sm-3">
         <label for="" class="form-label">Date of Birth <span class="text-danger">*</span></label>
         <input type="date" name="bday" value="<?php if(isset($bday)) echo $bday ?>" class="form-control <?= (form_error('bday')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('bday');?>
         </div>
      </div>
      <div class="col-sm-5">
         <label for="" class="form-label">Address <span class="text-danger">*</span></label>
         <input type="text" name="address" value="<?php if(isset($address)) echo $address ?>" class="form-control <?= (form_error('address')) ? 'is-invalid' : ''?>" placeholder="1234 Salty Springs St.">
         <div class="invalid-feedback">
            <?php echo form_error('address');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Zipcode <span class="text-danger">*</span></label>
         <input type="text" name="zipcode" value="<?php if(isset($zipcode)) echo $zipcode ?>" class="form-control <?= (form_error('zipcode')) ? 'is-invalid' : ''?>" placeholder="1118">
         <div class="invalid-feedback">
            <?php echo form_error('zipcode');?>
         </div>
      </div>
      <hr>
      <!-- STUDENT APPLICATION -->
      <h5 class="fw-bold mb-2">Student Application</h5>
      <div class="form-label">Enrollee Type <span class="text-danger">*</span></div>
      <div class="col-sm-12 d-flex">
         <div class="form-check mx-2">
            <input type="radio" name="enrolleeType" id="oldStud" value="1" class="form-check-input" onclick="enrollType();" <?php if(isset($selected_old)) echo "checked";?> required  >
            <labe class="form-check-label">Old Student</label>
         </div>
         <div class="form-check mx-2">
            <input type="radio" name="enrolleeType" id="newStud" value="2" class="form-check-input" onclick="enrollType();" <?php if(isset($selected_new)) echo "checked";?> required >
            <labe class="form-check-label">New Student</label>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Applying for  <span class="text-danger"> (Your Grade Level) *</span></label>
         <select name="grade_level" id=""  class="form-select <?= (form_error('grade_level')) ? 'is-invalid' : ''?>">
            <option value=""></option>
            <?php foreach($gradelevel as $i):?>
               <option value="<?=$i->gradelevelID?>"><?=$i->grade_title?> </option>
            <?php endforeach;?>
         </select>
         <div class="invalid-feedback">
            <?php echo form_error('grade_level');?>
         </div>
      </div>
      <div class="col-sm-6" id="PrevSchool" style="display: none;">
         <label for="" class="form-label">Previous School <span class="text-danger">*</span></label>
         <input type="text" name="previous_school" value="<?php if(isset($previous_school)) echo $previous_school ?>" id="" class="form-control <?= (form_error('previous_school')) ? 'is-invalid' : ''?>" placeholder="FEU TECH">
         <div class="invalid-feedback">
            <?php echo form_error('previous_school');?>
         </div>
      </div>
      <div class="col-sm-12" id="PrevSchoolAddress" style="display: none;">
         <label for="" class="form-label">Previous School Address <span class="text-danger">*</span></label>
         <input type="text" name="previous_school_address" value="<?php if(isset($previous_school_address)) echo $previous_school_address ?>" id="" class="form-control <?= (form_error('previous_school_address')) ? 'is-invalid' : ''?>" placeholder="Sampaloc, Manila, Paredes st.">
      </div>
      <hr>
      <h5 class="fw-bold mb-2">Guardian's Information </h5>
      <div class="col-sm-4">
         <label for="" class="form-label">First name <span class="text-danger">*</span></label>
         <input type="text" name="guardian_fname" value="<?php if(isset($guardian_fname)) echo $guardian_fname ?>" class="form-control <?= (form_error('guardian_fname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_fname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Middle name <span class="text-danger">*</span></label>
         <input type="text" name="guardian_mname" value="<?php if(isset($guardian_mname)) echo $guardian_mname ?>" class="form-control <?= (form_error('guardian_mname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_mname');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Last name <span class="text-danger">*</span></label>
         <input type="text" name="guardian_lname" value="<?php if(isset($guardian_lname)) echo $guardian_lname ?>" class="form-control <?= (form_error('guardian_lname')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_lname');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Email <span class="text-danger">*</span></label>
         <input type="email" name="guardian_email" value="<?php if(isset($guardian_email)) echo $guardian_email ?>" class="form-control <?= (form_error('guardian_email')) ? 'is-invalid' : ''?>" placeholder="you@email.com">
         <div class="invalid-feedback">
            <?php echo form_error('guardian_email');?>
         </div>
      </div>
      <div class="col-sm-6">
         <label for="" class="form-label">Phone Number <span class="text-danger">*</span></label>
         <div class="input-group">
            <span class="input-group-text">+63 (PH)</span>
            <input type="text" name="guardian_phone" value="<?php if(isset($guardian_phone)) echo $guardian_phone ?>" class="form-control <?= (form_error('guardian_phone')) ? 'is-invalid' : ''?>" placeholder="9123456789">
            <div class="invalid-feedback">
               <?php echo form_error('guardian_phone');?>
            </div>
         </div>
      </div>
      <input type="submit" value="Apply" class="btn btn-outline-primary mt-5">
   </div>
   <?= form_close()?>
</div>



<script type="text/javascript">

const radio_button = document.getElementById("newStud");
const prev_school = document.getElementById("PrevSchool");
const prev_school_address = document.getElementById("PrevSchoolAddress");

function enrollType() {
    if (document.getElementById('newStud').checked) {
        prev_school.style.display = 'block';
        prev_school_address.style.display = 'block';
      //   document.getElementById('ifYes').style.display = 'block';
    }
    else{ 
      prev_school.style.display = 'none';
      prev_school_address.style.display = 'none';
      // document.getElementById('ifYes').style.display = 'none';
   }

}

if(radio_button.checked)
{
   // document.getElementById('ifYes').style.display = 'block';
   prev_school.style.display = 'block';
   prev_school_address.style.display = 'block';
} else {
   // document.getElementById('ifYes').style.display = 'none';
   prev_school.style.display = 'none';
   prev_school_address.style.display = 'none';
}


</script>
