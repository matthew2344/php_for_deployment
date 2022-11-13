<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><i class="fa-solid fa-gear"></i> Create Setting</h4>
   </div>
   <hr>
   <?= form_open('Admin/')?>
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
      <input type="submit" value="Apply" class="btn btn-outline-primary mt-5">
   </div>
   <?= form_close()?>
</div>
