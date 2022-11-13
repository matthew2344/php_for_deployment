<div class="card-body border border-top-0 mb-2">
   <?php foreach($section_data as $i): ?>
    <?php $yearlevel = $i->grade_title?>
    <?php $sectionID = $i->sectionID?>
   <div class="row">
      <h4 class="fw-bold"><?=$i->section_name?></h4>
   </div>
   <hr>
   <h5 class="fw-bold">Detail information</h5>
   <div class="row g-2 pt-4">
      <div class="col-sm-6 d-flex">
         <h5>Section Name: <?=$i->section_name?></h5>
         <a href="" style="padding-left:5px"><i class="fa-regular fa-pen-to-square"></i></a>
      </div>
      <div class="col-sm-6">
         <h5>Section ID: <?=$i->sectionID?></h5>
      </div>
      <div class="col-sm-6 d-flex">
         <h5>Section Adviser: <?=$i->fname?> <?=$i->mname?> <?=$i->lname?></h5>
         <a href="" style="padding-left:5px"><i class="fa-regular fa-pen-to-square"></i></a>
      </div>
      <div class="col-sm-6 d-flex">
         <h5>Max Capacity: <?=$i->max_capacity?></h5>
         <a href="" style="padding-left:5px"><i class="fa-regular fa-pen-to-square"></i></a>
      </div>
      <div class="col-sm-6">
         <h5>Date created: <?=$i->section_datecreated?></h5>
      </div>
      <div class="col-sm-6">
         <h5>Year/Grade Level: <?=$i->grade_title?></h5>
      </div>
   </div>
   <hr>
   <h5 class="fw-bold mb-5">Student List (<?=$i->section_name?>)</h5>
   <?php endforeach; ?>
   <div class="row mb-4 g-2">
      <div class="col-sm-6 d-flex g-2">
         <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-left: 10px;"><i class="fa-solid fa-plus"></i> Add Student</button>
      </div>
   </div>
   <div class="row">
    <div class="card-content table-responsive mb-2 p-2">
        <table class="table">
            <thead>
                <tr class="fw-bold">
                    <td>#</td>
                    <td>School ID</td>
                    <td>First name</td>
                    <td>Middle name</td>
                    <td>Last name</td>
                    <td>Year/Grade Level</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
               <?php $s_count = 1?>
               <?php foreach($stud_list as $i):?>
               <tr>
                  <td><?=$s_count++?></td>
                  <td><?=$i->userID?></td>
                  <td><?=$i->fname?></td>
                  <td><?=$i->mname?></td>
                  <td><?=$i->lname?></td>
                  <td><?=$i->grade_title?></td>
                  <td></td>
               </tr>
               <?php endforeach;?>
            </tbody>
        </table>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Student to Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/student_section/".$this->uri->segment(3))?>
      <div class="modal-body">
        <label for="" class="form-label">Add Student (<?=$yearlevel?>)</label>
        <select name="student" id="" class="form-select">
            <option value=""><?php if(isset($students)) echo "Empty";?></option>
            <?php foreach($students as $i):?>
                <option value="<?=$i->userID?>"><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></option>
            <?php endforeach;?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?=form_close();?>
    </div>
    

  </div>

</div>
