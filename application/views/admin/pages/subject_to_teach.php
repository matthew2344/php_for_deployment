<div class="card-body border border-top-0 mb-2">
    <h4 class="fw-bold">
        <i class="fa-solid fa-chalkboard-user"></i> Teaching Subjects
    </h4>
    <hr>
    <div class="row">
        <div class="card-content table-responsive mb-2 p-2">
            <table class="table table-bordered">
                <thead class="fw-bold">
                    <tr>
                        <td>Section</td>
                        <td>Subject</td>
                        <td>Class Schedule</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach($teach as $i):?>
                    <tr>
                        <?=form_open('admin/delete_subject_teaching/'.$this->uri->segment(3))?>
                        <td><?=$i->section_name?></td>
                        <td>
                            <div class="col-12">
                                <p data-toggle="tooltip" title="<?=$i->subject_name?>" class="d-inline-block text-truncate" style="max-width: 500px;">
                                    <?=$i->subject_name?>
                                </p>
                            </div>
                        </td>
                        <td>
                            <?php foreach($subject as $o):?>
                                <?php if($i->subjectID == $o->subjectID):?>
                                <?php $text = substr($o->weekday, 0, 3);?>
                                    <?="$text : $i->schedule_start-$i->schedule_end"?>
                                <br>
                            
                                <?php endif;?>
                            <?php endforeach;?>
                        </td>
                        <td>
                            <?php foreach($subject as $o):?>
                                <?php if($i->subjectID == $o->subjectID):?>
                                    <input type="hidden" name="teach[]" value="<?=$o->teachID?>">
                                <?php endif;?>
                            <?php endforeach;?>
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </td>
                        <?= form_close();?>
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Teaching Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?=form_open("Admin/create_schedule/")?> -->
      <div class="modal-body">
        <div class="row g-2">
            <div class="col-sm-6">
                <label for="">Section</label>
                <select name="" id="" class="form-select">
                    <option value=""></option>
                </select>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <!-- <?=form_close();?> -->
    </div>
    
  </div>

</div>