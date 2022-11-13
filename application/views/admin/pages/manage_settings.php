<div class="card-body border border-top-0 mb-2">
   <?php foreach($school as $i):?>
      <?= form_open(base_url("admin/update_school/$i->schoolID"))?>
      <div class="col-sm-6">
         <label for="" class="form-label">School Name</label>
         <h4 class="fw-bold"><?=$i->school_name?></h4>
      </div>
      <hr>
      <div class="row g-3">
         <div class="col-sm-4">
            <label for="" class="form-label">School Name</label>
            <input type="text" name="name" id="" class="form-control <?= (form_error('name')) ? 'is-invalid' : ''?>" value="<?=$i->school_name?>">
            <div class="invalid-feedback">
               <?php echo form_error('name');?>
            </div>
         </div>
         <div class="col-sm-8">
            <label for="" class="form-label">School Address</label>
            <input type="text" name="address" id="" class="form-control <?= (form_error('address')) ? 'is-invalid' : ''?>" value="<?=$i->school_address?>">
            <div class="invalid-feedback">
               <?php echo form_error('address');?>
            </div>
         </div>
         <div class="col-sm-12">
            <label for="" class="form-label">School Description</label>
            <div class="input-group">
               <textarea name="description" id="" class="form-control"><?=$i->school_description?>
               </textarea>
            </div>
         </div>
         <div class="col-sm-4 mt-3">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-gear"></i> Update Settings</button>
         </div>

      </div>
      <?= form_close();?>
      <hr>
   <?php endforeach;?>
   <?php foreach($schoolyear as $i):?>
   <div class="col-sm-12">
      <h4 class="fw-bold">School Year Settings</h4>
   </div>
   <?= form_open(base_url("admin/update_year/$i->schoolyearID"))?>
   <div class="row">

      <div class="col-sm-4">
         <label for="" class="form-label">Start Year</label>
         <input type="number" name="start_year" id="" class="form-control <?= (form_error('start_year')) ? 'is-invalid' : ''?>" min="1900" max="2099" step="1" value="<?=$i->start_year?>">
         <div class="invalid-feedback">
            <?php echo form_error('start_year');?>
         </div>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">End Year</label>
         <input type="number" name="end_year" id="" class="form-control <?= (form_error('end_year')) ? 'is-invalid' : ''?>" min="1900" max="2099" step="1" value="<?=$i->end_year?>">
         <div class="invalid-feedback">
            <?php echo form_error('end_year');?>
         </div>
      </div>
   </div>
   <div class="col-sm-4 mt-3">
      <button class="btn btn-dark" type="submit"><i class="fa-solid fa-gear"></i> Update Settings</button>
   </div>
   <?= form_close();?>
   <?php endforeach;?>
   <hr>
   <?php foreach($gate_settings as $i):?>
   <div class="col-sm-12">
      <h4 class="fw-bold">Gate Settings</h4>
   </div>
   <?= form_open(base_url("admin/update_gate/$i->gate_settingsID"))?>
   <div class="row">
      <div class="col-sm-12 ">
         <p class="text-muted">Used to determine a person entering is late when exceeded beyond the time limit.</p>
      </div>
      <div class="col-sm-4">
         <label for="" class="form-label">Gate Entrance</label>
         <input type="time" name="gate_entry" id="" class="form-control <?= (form_error('gate_entry')) ? 'is-invalid' : ''?>" value="<?=$i->entry_setting?>">
         <div class="invalid-feedback">
            <?php echo form_error('gate_entry');?>
         </div>
      </div>
   </div>
   <div class="col-sm-4 mt-3">
      <button class="btn btn-dark" type="submit"><i class="fa-solid fa-gear"></i> Update Settings</button>
   </div>
   <?= form_close();?>
   <?php endforeach;?>

</div>
</div>
</div>