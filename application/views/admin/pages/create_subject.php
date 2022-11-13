<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold">Create Subject</h4>
   </div>
   <hr>
   <?= form_open('Admin/create_subject')?>
   <div class="row g-3">
      <div class="col-sm-4">
         <label for="" class="form-label">Subject Name <span class="text-danger">*</span></label>
         <input type="text" name="name" value="<?php if(isset($name)) echo $name ?>" class="form-control <?= (form_error('name')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('name');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Year/Grade level <span class="text-danger">*</span></label>
         <select name="year_level"  id="" class="form-select <?= (form_error('year_level')) ? 'is-invalid' : ''?>">
            <option value=""></option>
            <?php foreach($gradelevel as $i):?>
                <option value="<?=$i->gradelevelID?>"><?=$i->grade_title?></option>
            <?php endforeach;?>
         </select>
         <div class="invalid-feedback">
            <?php echo form_error('year_level');?>
         </div>
      </div>
      <div class="col-sm-12">
        <label for="" class="form-label">Description</label>
        <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
      </div>
      <input type="submit" value="Create Subject" class="btn btn-outline-primary mt-5">
   </div>
   <?= form_close()?>
</div>
