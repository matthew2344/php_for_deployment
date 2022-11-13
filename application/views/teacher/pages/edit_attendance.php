<div class="card-body border border-top-0 mb-2">
   <div class="mb-4 d-flex justify-content-between">
      <h4 class="fw-bold"><i class="fa-solid fa-calendar-check"></i> View Attendance</h4>
      <a href="<?=base_url('teacher/view_attendance/'.$this->uri->segment(3).'/'.$this->uri->segment(4))?>">Go back</a>
   </div>
   <hr>
   <?= form_open('teacher/update_attendance/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5))?>
    <div class="row">
            <div class="card-content table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="fw-bold">
                        <tr>
                            <td>Number</td>
                            <td>Student Name</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;?>
                        <?php foreach($student as $i):?>
                        <tr>
                            <td style="white-space: nowrap; width: 1%;"><?=$count++?></td>
                            <td><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></td>
                            <td style="white-space: nowrap;">
                                <input type="text" name="studID[]" id="" hidden value="<?=$i->student_attendanceID?>">
                                <select name="attendance[]" id="" class="form-select">
                                    <option value="<?=$i->attendance_status?>"><?=$i->attendance_title?></option>
                                    <?php foreach($attendance_status as $o):?>
                                        <?php if($o->attendance_status != $i->attendance_status):?>
                                            <option value="<?=$o->attendance_status?>"><?=$o->attendance_title?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <button class="btn btn-success" type="submit">Save Update</button>
            </div>
    </div>
    <?=form_close();?>


</div>
