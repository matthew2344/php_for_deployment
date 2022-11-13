<div class="main-content">
<div class="row ">
   <div class="col-12">
      <div class="card rounded" style="min-height: 485px">
         <div class="card-header card-header-text">
            <h4 class="card-title">Attendance Stats</h4>
            <p class="category">School-Year <?=date('Y')?></p>
         </div>
         <div class="card-content table-responsive">
            <div class="d-flex flex-row-reverse">
            <a href="<?= base_url("Teacher/dl_excel/")?><?=$_SESSION['uid']?>" class="btn btn-success mb-3"><i class="fa-solid fa-file-excel"></i> Export All Data</a>
            </div>
            <table class="table">
               <thead>
                  <tr>
                     <th class="fw-bold">SCHOOL ID</th>
                     <th class="fw-bold">Full Name</th>
                     <th class="fw-bold">Date</th>
                     <th class="fw-bold">Entry Time</th>
                     <th class="fw-bold">Exit Time</th>
                  </tr>
               </thead>
               <tbody>
                  <?php if(!$gatelog):?>
                     <tr>
                        <td colspan=5 class="text-center fw-bold">No existing data..</td>
                     </tr>
                  <?php endif;?>
                  <?php foreach($gatelog as $i):?>
                  <tr>
                     <td><?= $i->userID ?></td>
                     <td><?= $i->fname ?> <?= $i->mname ?> <?= $i->lname ?></td>
                     <td><?= $i->date ?></td>
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