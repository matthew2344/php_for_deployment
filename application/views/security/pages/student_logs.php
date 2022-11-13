<div class="main-content">
    <div class="row">
        <div class="card rounded">
            <div class="card-header d-flex justify-content-between">
                <h4 class="fw-bold">View <span class="fst-italic text-primary">Student Logs</span> <span class="text-muted">(<?=$date_value?>)</span></h4>
                <a href="<?=base_url('Security/gatelogs')?>">Go back</a>
            </div>
            <hr>
            <div class="card-body">
                <?=form_open('Security/student_date')?>
                    <div class="row">
                        <h5>Select Date</h5>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-2 col-sm-4 mt-2">
                            <input type="date" name="date_select" id="" class="form-control">
                        </div>
                        <div class="col-md-2 col-sm-4 mt-2">
                            <button type="submit" class="btn btn-primary">Go</button>
                        </div>
                    </div>
                <?=form_close()?>
                <div class="d-flex flex-row-reverse">
                    <a href="<?=base_url("Security/dl_excel/all/Student")?>" class="btn btn-success mb-3"><i class="fa-solid fa-file-excel"></i> Export All Data</a>
                </div>
                <hr>
                <div class="row">
                    <div class="card-content table-responsive">
                        <div class="d-flex justify-content-between flex-wrap">
                        <h5><?=($date_value == date('Y-m-d')) ? "You are viewing today's record ($date_value)" :  "You are viewing ($date_value)"?></h5>
                        <a href="<?=base_url("Security/dl_excel/$date_value/Student")?>" class="btn btn-success mb-3"><i class="fa-solid fa-file-excel"></i> Export data for(<?=($date_value)?>)</a>
                        </div>
                        <table class="table">
                            <thead class="fw-bold">
                                <tr>
                                    <td>School ID</td>
                                    <td>Full name</td>
                                    <td>Role</td>
                                    <td>Date</td>
                                    <td>Entry Time</td>
                                    <td>Exit Time</td>
     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$gatelog):?>
                                    <tr>
                                        <td colspan="6" class="text-center fw-bold"><?=($date_value == date('Y-m-d') ? "No data for today ($date_value)" : "No data for ($date_value)")?></td>
                                    </tr>
                                <?php endif;?>
                                <?php foreach($gatelog as $i):?>
                                    <tr>
                                        <td><?=$i->userID?></td>
                                        <td><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></td>
                                        <td><?=$i->role?></td>
                                        <td><?=$i->date?></td>
                                        <td><?= ($i->entry_time == "00:00:00") ?  "N/A" : $i->entry_time?></td>
                                        <td><?= ($i->exit_time == "00:00:00") ?  "N/A" : $i->exit_time ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <?=$pagination?>
                    </div>
                </div>
            </div>

        </div>
    </div>
