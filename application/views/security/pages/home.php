
<div class="main-content">
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 rounded">
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
<div class="row ">
   <div class="col-lg-12 col-md-12 rounded">
      <div class="card rounded" style="min-height: 485px">
         <div class="card-header card-header-text">
            <h4 class="card-title">Attendance Stats</h4>
            <p class="category">School-Year 2022-2023</p>
         </div>
         <div class="card-content table-responsive">
            <table class="table table-hover">
               <thead class="text-primary">
                  <tr>
                     <th>ID</th>
                     <th>Date</th>
                     <th>Entry Time</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>1</td>
                     <td>2022-07-17</td>
                     <td>11:00AM</td>
                     <td>PRESENT</td>
                  </tr>
                  <tr>
                     <td>2</td>
                     <td>2022-07-18</td>
                     <td>11:00AM</td>
                     <td>PRESENT</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>


<script defer>
   // var number= 0;
   const awit = document.getElementById("awit");


</script>
