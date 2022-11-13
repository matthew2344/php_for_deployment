<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><i class="fa-regular fa-pen-to-square"></i> Edit Subject</h4>
   </div>
   <hr>
   <?php foreach($subject as $i):?>
   <?= form_open('Admin/update_subject/'.$i->subjectID)?>
   <div class="row g-3">
      <div class="col-sm-4">
         <label for="" class="form-label">Subject Name <span class="text-danger">*</span></label>
         <input type="text" name="name" value="<?php if(isset($name)){ echo $name;}else{echo $i->subject_name;}?>" class="form-control <?= (form_error('name')) ? 'is-invalid' : ''?>">
         <div class="invalid-feedback">
            <?php echo form_error('name');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Year/Grade level <span class="text-danger">*</span></label>
         <select name="year_level"  id="" class="form-select <?= (form_error('year_level')) ? 'is-invalid' : ''?>">
            <option value="<?=$i->gradelevelID?>"><?=$i->grade_title?></option>
            <?php foreach($gradelevel as $o):?>
                <?php if($i->gradelevelID != $o->gradelevelID):?>
                    <option value="<?=$o->gradelevelID?>"><?=$o->grade_title?></option>
                <?php endif;?>
            <?php endforeach;?>
         </select>
         <div class="invalid-feedback">
            <?php echo form_error('year_level');?>
         </div>
      </div>
      <div class="col-sm-12">
        <label for="" class="form-label">Description</label>
        <textarea name="description" id="" cols="30" rows="10" class="form-control"><?php if(isset($description)){ echo $description;}else{echo $i->subject_description;}?>
        </textarea>
      </div>
      <input type="submit" value="Edit Subject" class="btn btn-outline-primary mt-5">
   </div>
   <?= form_close()?>
   <?php endforeach;?>
</div>
