<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><i class="fa-solid fa-calendar-check"></i> Student Attendance</h4>
   </div>
   <hr>
   <div class="row">
    <div class="card-content table-responsive">
        <table class="table table-bordered">
            <thead class="fw-bold">
                <tr>
                    <td colspan="3">
                        <h4 class="fw-bold text-center">
                            My Attendance
                        </h4>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;?>
                <?php foreach($my_attendance as $i):?>
                <tr>
                    <td><?=$count++?></td>
                    <td><?=$i->date?></td>
                    <td class="fw-semibold"><?=$i->attendance_title?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
   </div>
 


</div>
