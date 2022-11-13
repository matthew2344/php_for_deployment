<div class="card-body border border-top-0 mb-2">
    <h4 class="fw-bold">
        <i class="fa-solid fa-chalkboard-user"></i> Add Teaching Subjects
    </h4>
    <hr>
    <div class="row">
        <div class="card-content table-responsive mb-2 p-2">

            <table class="table table-striped table-bordered">
                <thead class="fw-bold">
                    <tr>
                        <td class="text-center"># </td>
                        <td class="text-center">Section Class</td>
                        <td class="col-2 text-center">Subject Name</td>
                        <td class="text-center">Class Time</td>
                        <td class="text-center">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!$schedules):?>
                        <tr>
                            <td colspan="5" class="fw-bold text-center">No Subject Available...</td>
                        </tr>
                    <?php endif?>
                    <?php $count = 1;?>
                    <?php foreach($schedules as $i):?>
                    <?=form_open('admin/insert_subject_teaching/'.$this->uri->segment(3))?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$i->section_name?></td>
                        <td>
                            <div class="col-12">
                                <p data-toggle="tooltip" title="<?=$i->subject_name?>" class="d-inline-block text-truncate" style="max-width: 200px;">
                                    <?=$i->subject_name?>
                                </p>
                            </div>
                        </td>
                        <td>
                            <?php foreach($subject as $o):?>
                                <?php if($i->subjectID == $o->subjectID && $i->sectionID == $o->sectionID):?>
                                <?php $text = substr($o->weekday, 0, 3);?>
                                    <?="$text : $i->schedule_start-$i->schedule_end"?>
                                <br>
                                
                                <?php endif;?>
                            <?php endforeach;?>
                        </td>
                        <td style="white-space:nowrap; width:1%">
                            <?php foreach($subject as $o):?>
                                <?php if($i->subjectID == $o->subjectID && $i->sectionID == $o->sectionID):?>
                                    <input type="hidden" name="schedule[]" value="<?=$o->scheduleID?>">
                                <?php endif;?>
                            <?php endforeach;?>
                            
                            <button class="btn btn-success"><i class="fa-sharp fa-solid fa-plus"></i> Add Teaching Subject</button>
                        </td>
                    </tr>
                    <?=form_close()?>
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>

</div>
</div>
</div>