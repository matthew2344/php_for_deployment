<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><i class="fa-solid fa-book"></i> Syllabus</h4>
   </div>
   <hr>
    <div class="row">
        <div class="card-content table-responsive">
            <table class="table table-bordered">
                <thead class="fw-bold">
                    <tr>
                        <td colspan="2" class="text-center">
                            <h5 class="fw-bold">Class Schedules</h5>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($schedule_subject as $i):?>
                    <tr class="text-center">
                        <td class="fw-semibold"><?=$i->weekday?></td>
                        <td><?=$i->schedule_start?>-<?=$i->schedule_end?></td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row p-4">
        <div class="card bg-dark text-light p-3 rounded">
            <div class="col-sm-12 text-center">
                <h4 class="fw-bold"><?=$title_viewed?></h4>
            </div>
            <div class="col-sm-12 text-center mt-4">
                <p class="fw-semibold"><?=$subject_description?></p>
                <p class="fw-semibold">Teacher: <?=$teacher?></p>
            </div>
        </div>
    </div>


</div>
