<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold">Create Section</h4>
   </div>
   <hr>
   <?= form_open('Admin/create_section')?>
   <div class="row g-3">
      <div class="col-sm-4">
         <label for="" class="form-label">Section Name <span class="text-danger">*</span></label>
         <input type="text" name="name" value="<?php if(isset($name)) echo $name ?>" class="form-control <?= (form_error('name')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('name');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Section Adviser <span class="text-danger">*</span></label>
         <select name="teacher" id="" class="form-select <?= (form_error('teacher')) ? 'is-invalid' : ''?>">
            <option value=""></option>
            <?php foreach($teacher as $i):?>
                <option value="<?=$i->userID?>"><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></option>
            <?php endforeach;?>
         </select>
         <div class="invalid-feedback">
            <?php echo form_error('teacher');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Max Capacity <span class="text-danger">*</span></label>
         <input type="number" name="max" value="<?php if(isset($max)) echo $max ?>" class="form-control <?= (form_error('max')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('max');?>
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
      <hr>
      <input type="submit" value="Apply" class="btn btn-outline-primary mt-5">
   </div>
   <?= form_close()?>
</div>
