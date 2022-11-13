<div class="card-body border border-top-0 mb-2">
        <?=form_open('Admin/all_logs')?>
            <div class="row">
                <h5>Select Date</h5>
            </div>
            <div class="row mb-4">
                <div class="col-sm-2">
                    <input type="date" name="date_select" id="" class="form-control">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Go</button>
                </div>
            </div>
        <?=form_close()?>
            <div class="d-flex flex-row-reverse">
                <a href="<?=base_url("Admin/dl_excel/all")?>" class="btn btn-success mb-3"><i class="fa-solid fa-file-excel"></i> Export All Data</a>
            </div>
            <hr>
         <div class="row">

               <div class="card-content table-responsive mb-2 p-2">
                    <div class="d-flex justify-content-between flex-wrap">
                        <h5><?=($date_value == date('Y-m-d')) ? "You are viewing today's record ($date_value)" :  "You are viewing ($date_value)"?></h5>
                        <a href="<?=base_url("Admin/dl_excel/$date_value")?>" class="btn btn-success mb-3"><i class="fa-solid fa-file-excel"></i> Export data for (<?=($date_value)?>)</a>
                    </div>
                  <table class="table">
                     <thead>
                        <tr class="fw-bold">
                           <td>School ID</td>
                           <td>Firstname</td>
                           <td>Middlename</td>
                           <td>Lastname</td>
                           <td>Date</td>
                           <td>Entry Time</td>
                           <td>Exit Time</td>
                        </tr>
                     </thead>
                     <tbody>
                     <?php if(!$gatelog):?>
                         <tr>
                             <td colspan="7" class="text-center fw-bold"><?=($date_value == date('Y-m-d') ? "No data for today ($date_value)" : "No data for ($date_value)")?></td>
                         </tr>
                     <?php endif;?>
                     <?php foreach($gatelog as $i):?>
                        <tr>
                            <td><?=$i->userID?></td>
                            <td><?=$i->fname?></td>
                            <td><?=$i->mname?></td>
                            <td><?=$i->lname?></td>
                            <td><?=$i->date?></td>
                            <td><?= ($i->entry_time == "00:00:00") ?  "N/A" : $i->entry_time?></td>
                            <td><?= ($i->exit_time == "00:00:00") ?  "N/A" : $i->exit_time ?></td>
                        </tr>
                     <?php endforeach;?>
    
                     </tbody>
                  </table>
               </div>

         </div>
         <p><?php echo $pagination; ?></p>
      </div>
   </div>
</div>


<script Src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function () {    
    var allOptions = $('#section option')
    $('#year_level').change(function () {
        $('#section option').remove()
        var classN = $('#year_level option:selected').prop('class');
        var opts = allOptions.filter('.' + classN);
        $.each(opts, function (i, j) {
            $(j).appendTo('#section');
        });
    });
});
</script>