<div class="card-body border border-top-0 mb-2">
   <?php foreach($section_data as $i): ?>
    <?php $yearlevel = $i->grade_title?>
    <?php $sectionID = $i->sectionID?>
   <div class="row">
      <h4 class="fw-bold">Manage Schedule Schema (<?=$i->section_name?>)</h4>
   </div>
   <hr>
   <div class="row">
    <div class="col-sm-3">
      <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success"><i class="fa-sharp fa-solid fa-plus"></i> Add Class Schedule</button>
    </div>
   </div>
   <?php endforeach; ?>
   <div class="row">
    <div class="card-content table-responsive mb-2 p-2">
      <table class="table table-bordered ">
        <thead class="fw-bold">
          <tr>
            <?php foreach($weekdays as $i):?>
              <td class="py-3 px-5 text-center"><?=date('l', strtotime($i))?></td>
            <?php endforeach;?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="height: 100px; max-width:200px">
              <?php foreach($monday_scheds as $i):?>
                <div class="bg-primary text-light px-2  rounded my-2 fw-semibold text-truncate">
                  <?=$i->subject_name?>
                  <br>
                  Start: <?=$i->schedule_start?>
                  <br>
                  End: <?=$i->schedule_end?>
                </div>

              <?php endforeach;?>
            </td>
            <td style="height: 100px; max-width:200px">
              <?php foreach($tuesday_scheds as $i):?>
                <div class="bg-primary text-light px-2  rounded my-2 fw-semibold text-truncate">
                  <?=$i->subject_name?>
                  <br>
                  Start: <?=$i->schedule_start?>
                  <br>
                  End: <?=$i->schedule_end?>
                </div>

              <?php endforeach;?>
            </td>
            <td style="height: 100px; max-width:200px">
              <?php foreach($wednesday_scheds as $i):?>
                <div class="bg-primary text-light px-2  rounded my-2 fw-semibold text-truncate">
                  <?=$i->subject_name?>
                  <br>
                  Start: <?=$i->schedule_start?>
                  <br>
                  End: <?=$i->schedule_end?>
                </div>

              <?php endforeach;?>
            </td>
            <td style="height: 100px; max-width:200px">
              <?php foreach($thursday_scheds as $i):?>
                <div class="bg-primary text-light px-2  rounded my-2 fw-semibold text-truncate">
                  <?=$i->subject_name?>
                  <br>
                  Start: <?=$i->schedule_start?>
                  <br>
                  End: <?=$i->schedule_end?>
                </div>

              <?php endforeach;?>
            </td>
            <td style="height: 100px; max-width:200px">
              <?php foreach($friday_scheds as $i):?>
                <div class="bg-primary text-light px-2  rounded my-2 fw-semibold text-truncate">
                  <?=$i->subject_name?>
                  <br>
                  Start: <?=$i->schedule_start?>
                  <br>
                  End: <?=$i->schedule_end?>
                </div>

              <?php endforeach;?>
            </td>
            <td style="height: 100px; max-width:200px">
              <?php foreach($saturday_scheds as $i):?>
                <div class="bg-primary text-light px-2  rounded my-2 fw-semibold text-truncate">
                  <?=$i->subject_name?>
                  <br>
                  Start: <?=$i->schedule_start?>
                  <br>
                  End: <?=$i->schedule_end?>
                </div>
              <?php endforeach;?>
            </td>
          </tr>
        </tbody>
      </table>
        <!-- <table class="table">
            <thead class="fw-bold">
                <tr>
                    <td>Subject Name</td>
                    <td>Starting Schedule</td>
                    <td>Dismissal Schedule</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if(!isset($schedule)):?>
                    <tr>
                        <td colspan="4" class="text-center">No Schedule..</td>
                    </tr>
                <?php endif;?>
                <?php foreach($schedule as $i):?>
                    <?php $create_start = date_create($i->schedule_start);
                          $start = date_format($create_start,"h:i")?>
                    <?php $create_end = date_create($i->schedule_end);
                          $end = date_format($create_end,"h:i")?>
                <tr>
                    <td>
                        <?=$i->subject_name?>
                    </td>
                    <td>
                        <?=$i->schedule_start?>
                    </td>
                    <td>     
                        <?=$i->schedule_end?>
                    </td>
                    <td>
                        <button class="btn btn-success p-1 px-2" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$i->scheduleID?>"><i class="fa-regular fa-pen-to-square fa-lg"></i></button>
                        <a href="" class="btn btn-danger p-1 px-2"><i class="fa-solid fa-xmark fa-lg p-1"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>

        </table>
        <?=$pagination?> -->
    </div>
    <h4 class="fw-bold">Weekly Schedules</h4>
    <hr>
    <?php foreach($weekdays as $i):?>
    <div class="row">
      <h5 class="fw-semibold"><?=$i?></h5>
      <div class="card-content table-responsive">
        <table class="table table-bordered">
          <thead class="fw-bold">
            <tr>
              <td>#</td>
              <td>Subject</td>
              <td>Section</td>
              <td>Schedule Start</td>
              <td>Schedule End</td>
              <td colspan="2" class="text-center">Action</td>
            </tr>
          </thead>
          <tbody>
            <?php 
              switch ($i) {
                case 'Monday':
                  $sched_array = $monday_scheds;
                  break;
                case 'Tuesday':
                  $sched_array = $tuesday_scheds;
                  break;
                case 'Wednesday':
                  $sched_array = $wednesday_scheds;
                  break;
                case 'Thursday':
                  $sched_array = $thursday_scheds;
                  break;
                case 'Friday':
                  $sched_array = $friday_scheds;
                  break;
                case 'Saturday':
                  $sched_array = $saturday_scheds;
                  break;
                
                default:
                  # code...
                  break;
              }
            ?>
              <?php $count = 1;?>
              <?php foreach($sched_array as $x):?>
                <tr>
                  <td><?=$count++?></td>
                  <td class="text-truncate"><?=$x->subject_name?></td>
                  <td><?=$x->section_name?></td>
                  <td><?=$x->schedule_start?></td>
                  <td><?=$x->schedule_end?></td>
                  <td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$x->scheduleID?>">Edit</button></td>
                  <td><button class="btn btn-danger">Delete</button></td>
                </tr>
              <?php endforeach;?>
          </tbody>
        </table>
      </div>
        <!-- <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-sharp fa-solid fa-plus"></i></button> -->
    </div>
    <?php endforeach;?>
    
   </div>
</div>
</div>
</div>



<?php foreach($schedule as $i):?>
<?php $create_start = date_create($i->schedule_start);
  $start = date_format($create_start,"h:i")?>
<?php $create_end = date_create($i->schedule_end);
  $end = date_format($create_end,"h:i")?>
<div class="modal fade" id="exampleModal<?=$i->scheduleID?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/update_schedule/".$this->uri->segment(3)."/$i->scheduleID")?>
      <div class="modal-body">
        <div class="row g-2">

            <label for="" class="form-label"></label>
            <select name="subject" id="" class="form-select">
                <option value="<?=$i->subjectID?>"><?=$i->subject_name?></option>

                <?php foreach($subjects as $o):?>
                    <?php if($i->subjectID != $o->subjectID):?>
                      <option value="<?=$o->subjectID?>"><?=$o->subject_name?></option>
                    <?php endif;?>
                <?php endforeach;?>
            </select>
            <label for="" class="form-label">Weekday</label>
            <select name="weekday" id="" class="form-select">
              <option value="<?=$i->weekday?>"><?=$i->weekday?></option>
              <?php foreach($weekdays as $o):?>
                <?php if($i->weekday != $o):?>
                  <option value="<?=$o?>"><?=$o?></option>
                <?php endif;?>
              <?php endforeach;?>
            </select>
            <label for="" class="form-label">Start Schedule <span class="text-danger">*</span> <span class="text-muted">example: 6:00 AM</span></label>
            <div class="input-group">
                <div class="input-group-text"><i class="fa-regular fa-clock"></i></div>
                <input type="time" value="<?=$start?>" name="time_start" id="" class="form-control">
            </div>
            <label for="" class="form-label">End Schedule <span class="text-danger">*</span> <span class="text-muted">example: 4:00 PM</span></label>
            <div class="input-group">
                <div class="input-group-text"><i class="fa-regular fa-clock"></i></div>
                <input type="time" value="<?=$end?>"  name="time_end" id="" class="form-control">
            </div>
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













 





<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Subject Schedule (<?=$yearlevel?>)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/create_schedule/".$this->uri->segment(3))?>
      <div class="modal-body">
        <div class="row">

          <div class="col-sm-6">
            <label for="" class="form-label">Select Subject <span class="text-danger">*</span></label>
            <select name="subject" id="" class="form-select">
              <option value=""><?php if(!isset($subjects)) echo "Empty";?></option>
              <?php foreach($subjects as $i):?>
                <option value="<?=$i->subjectID?>"><?=$i->subject_name?></option>
              <?php endforeach;?>
            </select>        
          </div>
          <div class="col-sm-6">
            <label for="" class="form-label">Select Weekday <span class="text-danger">*</span></label>
            <select name="weekday" id="" class="form-select">
              <option value=""></option>
              <option value="<?=date('l', strtotime('monday'))?>"><?=date('l', strtotime('monday'))?></option>
              <option value="<?=date('l', strtotime('tuesday'))?>"><?=date('l', strtotime('tuesday'))?></option>
              <option value="<?=date('l', strtotime('wednesday'))?>"><?=date('l', strtotime('wednesday'))?></option>
              <option value="<?=date('l', strtotime('thursday'))?>"><?=date('l', strtotime('thursday'))?></option>
              <option value="<?=date('l', strtotime('friday'))?>"><?=date('l', strtotime('friday'))?></option>
            </select>
          </div>
          <label for="" class="form-label">Start Schedule <span class="text-danger">*</span> <span class="text-muted">example: 6:00 AM</span></label>
          <div class="input-group">
              <div class="input-group-text"><i class="fa-regular fa-clock"></i></div>
              <input type="time"  name="time_start" id="" class="form-control">
          </div>
          <label for="" class="form-label">End Schedule <span class="text-danger">*</span> <span class="text-muted">example: 4:00 PM</span></label>
          <div class="input-group">
              <div class="input-group-text"><i class="fa-regular fa-clock"></i></div>
              <input type="time"  name="time_end" id="" class="form-control">
          </div>
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
