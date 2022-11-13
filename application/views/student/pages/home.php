<div class="main-content">
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card card-stats rounded">
         <div class="card-header">
            <div class="icon">
               <h1 class="fw-bold">Welcome back!</h1>
            </div>
         </div>
         <div class="card-content">
            <h4 class="text-primary fw-bold text-center"><?=$_SESSION['fname']?> <?=$_SESSION['mname']?> <?=$_SESSION['lname']?></h4>
         </div>
         <div class="card-footer">
            <div class="stats">
               <i class="material-icons text-info">info</i>
               <a href="#pablo">See detailed Attendance</a>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="card rounded p-2">
   <div class="row">
      <?php foreach($my_subject as $i): ?>
      <div class="col-sm-5 col-md-6 col-sm-6">
         <a href="<?=base_url("student/this_class/$i->subjectID/$i->sectionID")?>" class="text-decoration-none">
   
            <div class="card rounded shadow">
               <div class="bg-dark bg-gradient border-bottom p-2 rounded-top">
                  <h5 class="fw-bold text-light text text-center text-truncate p-5"><?=$i->subject_name?></h5>
               </div>
               <div class="row p-2">
                  <p class="text-truncate text-decoration-underline fw-bold"><?=$i->section_name?>_<?=$i->subject_name?></p>
               </div>
            </div>
   
         </a>
      </div>
      <?php endforeach; ?>
   </div>
</div>