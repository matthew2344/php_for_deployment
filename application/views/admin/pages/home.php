<div class="main-content">
<div class="row">
   <div class="col-sm-4">
      <div class="card card-stats rounded">
         <div class="card-header">
            <?php if(isset($_SESSION['ERROR_TRAINING'])):?>
               <div class="alert alert-danger rounded ">
                  <?= $this->session->flashdata('ERROR_TRAINING')?>
               </div>
            <?php endif;?>
            <?php if(isset($_SESSION['TRAINING'])):?>
               <div class="alert alert-warning rounded " id="get_response">
                  <?= $this->session->flashdata('TRAINING')?>
               </div>
            <?php endif;?>
            <div class="icon text-primary">
               <span class="material-icons"><span class="material-symbols-outlined">familiar_face_and_zone</span></span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Face Images</strong></p>
            <h3 class="card-title"><?=$face_count?></h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo" data-bs-toggle="modal" data-bs-target="#exampleModal">Train Newly Added Faces</a>
            </div>
         </div>
      </div>
   </div>
   <!-- <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats rounded">
         <div class="card-header">
            <div class="icon icon-rose">
               <span class="material-icons">equalizer</span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Attended Teacher</strong></p>
            <h3 class="card-title">102</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See Entry logs</a>
            </div>
         </div>
      </div>
   </div> -->
   <!-- <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-header">
            <div class="icon icon-success">
               <span class="material-icons">
               equalizer
               </span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Attended Students</strong></p>
            <h3 class="card-title">102</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See Entry logs</a>
            </div>
         </div>
      </div>
   </div> -->
   <!-- <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
         <div class="card-header">
            <div class="icon icon-info">
               <span class="material-icons">
               equalizer
               </span>
            </div>
         </div>
         <div class="card-content">
            <p class="category"><strong>Attended Staff</strong></p>
            <h3 class="card-title">102</h3>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See Entry logs</a>
            </div>
         </div>
      </div>
   </div> -->
</div>
<div class="row ">
   <div class="col-lg-12 col-md-12 rounded">
      <div class="card rounded" style="min-height: 485px">
         <div class="card-header card-header-text">
            <h4 class="card-title">Admin View</h4>
            <p class="category">Ordered by ID</p>
         </div>
         <div class="card-content table-responsive">
            <table class="table table-hover">
               <thead class="text-primary">
                  <tr>
                     <th>User ID</th>
                     <th>Name</th>
                     <th>Role</th>
                     <th>Email</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($admin as $i): ?>
                  <tr>
                     <td><?=$i->userID?></td>
                     <td><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></td>
                     <td><?=$i->role_title?></td>
                     <td><?=$i->email?></td>
                  </tr>
                  <?php endforeach; ?>
                  <tr>
                  </tr>
               </tbody>
            </table>
            <?=$pagination?>
         </div>
      </div>
   </div>
   <!-- <div class="col-lg-5 col-md-12">
      <div class="card" style="min-height: 485px">
         <div class="card-header card-header-text">
            <h4 class="card-title">Activities</h4>
         </div>
         <div class="card-content">
            <div class="streamline">
               <div class="sl-item sl-primary">
                  <div class="sl-content">
                     <small class="text-muted">5 mins ago</small>
                     <p>Williams joined as Admin</p>
                  </div>
               </div>
               <div class="sl-item sl-danger">
                  <div class="sl-content">
                     <small class="text-muted">25 mins ago</small>
                     <p>Jane Edited Student Information</p>
                  </div>
               </div>
               <div class="sl-item sl-success">
                  <div class="sl-content">
                     <small class="text-muted">40 mins ago</small>
                     <p>You added you a new User</p>
                  </div>
               </div>
               <div class="sl-item">
                  <div class="sl-content">
                     <small class="text-muted">45 minutes ago</small>
                     <p>John Deleted a User</p>
                  </div>
               </div>
               <div class="sl-item sl-warning">
                  <div class="sl-content">
                     <small class="text-muted">55 mins ago</small>
                     <p>Jim changed school calendar</p>
                  </div>
               </div>
               <div class="sl-item">
                  <div class="sl-content">
                     <small class="text-muted">60 minutes ago</small>
                     <p>John added a new staff</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> -->
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Train Face Images</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         Press Continue to Train Faces.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="<?=base_url('Admin/train_data')?>" class="btn btn-primary">Continue</a>
      </div>
    </div>
    

  </div>

</div>




<?php if(isset($_SESSION['TRAINING'])):?>
    <script defer>
        const get_response = document.getElementById("get_response");

        function do_process()
        {
            $.ajax({
                url: "http://localhost:8000/data_process",
                type: "GET",
                dataType: "json",
                jsonpCallback: 'processJSONPResponse',
                contentType: "application/json; charset=utf-8",
                crossDomain:true,
                success: function(data){
                    get_response.innerHTML = data.Data
                },
                error: function(xhr, status, error){
                    console.log("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
                },
                complete:function()
                {
                    do_training();
                }
            });
        }

        function do_training()
        {
            $.ajax({
                url: "http://localhost:8000/train",
                type: "GET",
                dataType: "json",
                jsonpCallback: 'processJSONPResponse',
                contentType: "application/json; charset=utf-8",
                crossDomain:true,
                success: function(data){
                    get_response.innerHTML = data.Data
                },
                error: function(xhr, status, error){
                    console.log("Result: " + status + " " + error + " " + xhr.status + " " + xhr.statusText)
                }
            });
        }

        do_process();


    </script>
<?php endif;?>