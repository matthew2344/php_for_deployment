<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><i class="fa-solid fa-calendar-check"></i> Mark Attendance</h4>
   </div>
   <hr>
   <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <?=form_open('teacher/mark_date/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>
            <label for="" class="form-label">Date</label>
            <div class="input-group <?= (form_error('date')) ? 'is-invalid' : ''?>">
                <input type="date" name="date" id="" class="form-control <?= (form_error('date')) ? 'is-invalid' : ''?>" 
                value="<?=(isset($date_value)) ? $date_value : '' ?>">
                <input type="submit" value="Go" class="btn btn-primary">
            </div>         
            <div class="invalid-feedback">
                <?php echo form_error('date');?>
            </div>
            <?=form_close();?>
        </div>

   </div>
<?php if(isset($mark_mode)):?>
    <?=form_open('teacher/create_attendance/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>
    <div class="row">
        <?php if(isset($schedule)):?>
            <?php foreach($schedule as $i): ?>
                <div class="col-sm-3">
                    <label for="" class="form-label">Start Time</label>
                    <input type="time" name="" id="" value="<?=$i->schedule_start?>" class="form-control" disabled>
                </div>
                <div class="col-sm-3">
                    <label for="" class="form-label">End Time</label>
                    <input type="time" name="" id=""  value="<?=$i->schedule_end?>" class="form-control" disabled>
                </div>
                <input type="text" name="scheduleID" value="<?=$i->scheduleID?>" id="" hidden >
            <?php endforeach; ?>
        <?php endif;?>
    </div>
    <div class="row">
            <div class="card-content table-responsive">
                <table class="table table-striped">
                    <thead class="fw-bold">
                        <tr>
                            <td>Number</td>
                            <td>Student Number</td>
                            <td>Full Name</td>
                            <td>Attendance Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($students)):?>
                            <?php $count = 1;?>
                            <?php foreach($students as $i):?>
                            <tr>
                                <td><?=$count++?></td>
                                <td><?=$i->userID?></td>
                                <td><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></td>
                                <td>
                                    <input type="text" name="student[]" id="" hidden value="<?=$i->userID?>">
                                    <input type="date" name="date" id="" hidden value="<?=$date_value?>">
                                    <select name="status[]" id="" class="form-select">
                                        <?php foreach($attendance_status as $a):?>
                                            <option value="<?=$a->attendance_status?>"><?=$a->attendance_title?></option>
                                        <?php endforeach;?>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="4" class="text-center fw-bold">There is no scheduled class to this date.</td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table>
                <?php if(isset($students)):?>
                <div class="col-sm-3">
                    <button class="btn btn-success" type="submit">Save Record</button>
                </div>
                <?php endif;?>
            </div>
    </div>

<?php endif;?>

</div>
