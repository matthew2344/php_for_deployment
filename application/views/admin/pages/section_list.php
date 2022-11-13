<div class="card-body border border-top-0 mb-2">
         <div class="row mb-4">
            <div class="col-lg-4 col-sm-6 d-flex">
               <?= form_open('Admin/search_section', array('class' => 'd-flex'))?>
               <input class="form-control me-2" type="search" name="search_section" placeholder="Search" aria-label="Search" value="<?php if(isset($search)){ echo $search;}else{}?>">
               <button class="btn btn-primary" type="submit" >Search</button>
               <?= form_close();?>
            </div>
         </div>
         <div class="row">

               <div class="card-content table-responsive mb-2 p-2">
                  <table class="table">
                     <thead>
                        <tr class="fw-bold">
                           <td>Section ID</td>
                           <td>Section Name</td>
                           <td>Section Adviser</td>
                           <td>Max Capacity</td>
                           <td>Year/Grade level</td>
                           <td></td>
                        </tr>
                     </thead>
                     <tbody>
                     <?php foreach($sections as $i):?>
                        <tr>
                           <td><?= $i->sectionID?></td>
                           <td><?= $i->section_name?></td>
                           <td><?= $i->fname?> <?= $i->mname?> <?= $i->lname?></td>
                           <td><?= $i->max_capacity?></td>
                           <td><?= $i->grade_title?></td>
                           <td>
                              <a href="<?=base_url('Admin/view_section/'.$i->sectionID)?>" class="btn"><i class="material-icons">search</i></a>
                              <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$i->sectionID?>" class="btn text-danger"><i class="material-icons">delete</i></a> 
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


<?php foreach($sections as $i):?>
<!-- Modal -->
<div class="modal fade" id="exampleModal<?=$i->sectionID?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-light">
        <h5 class="modal-title" id="exampleModalLabel">Danger: Continue Delete Section?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?=form_open("Admin/delete_section/$i->sectionID")?>
      <div class="modal-body">
         <h5>Are you sure you want to remove this section forever?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete Section</button>
      </div>
      <?=form_close();?>
    </div>
    

  </div>

</div>
<?php endforeach; ?>

