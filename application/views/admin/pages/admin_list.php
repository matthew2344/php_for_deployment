<div class="card-body border border-top-0 mb-2">
         <div class="row mb-4">
            <div class="col-lg-4 col-sm-6 d-flex">
               <?= form_open('Admin/search_staff', array('class' => 'd-flex'))?>
               <input class="form-control me-2" type="search" name="search_staff" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
               <button class="btn btn-primary" type="submit" >Search</button>
               <?= form_close();?>
            </div>
         </div>
         <div class="row">

               <div class="card-content table-responsive mb-2 p-2">
                  <table class="table">
                     <thead>
                        <tr class="fw-bold">
                           <td>School ID</td>
                           <td>Firstname</td>
                           <td>Middlename</td>
                           <td>Lastname</td>
                           <td>Account Status</td>
                           <td></td>
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach($admins as $i):?>
                        <tr>
                           <td><?= $i->userID?></td>
                           <td><?= $i->fname?></td>
                           <td><?= $i->mname?></td>
                           <td><?= $i->lname?></td>
                           <td class="<?= ($i->status == 0) ? 'text-danger' : 'text-success'?>"><?= ($i->status == 0) ? 'Inactive' : 'Active'?></td>
                           <td>
                              <a href="<?=base_url('Admin/view_admin/'.$i->userID)?>" class="btn"><i class="material-icons">search</i></a>
                              <a href="<?=base_url('Admin/edit_admin/'.$i->userID)?>" class="btn"><i class="material-icons">edit</i></a> 
                              <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$i->userID?>" class="btn text-danger"><i class="material-icons">delete</i></a> 
                           </td>
                        </tr>
                     <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>

         </div>
         <p><?php echo $pagination; ?></p>
      </div>
   </div>
</div>


<?php foreach($admins as $i):?>
<!-- Modal -->
<div class="modal fade" id="exampleModal<?=$i->userID?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-light">
        <h5 class="modal-title" id="exampleModalLabel">Danger: Continue Delete User?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/delete_admin/$i->userID")?>
      <div class="modal-body">
         Deleting a user will ultimately be removed forever
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete User</button>
      </div>
      <?=form_close();?>
    </div>
    

  </div>

</div>
<?php endforeach; ?>


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