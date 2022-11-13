<div class="card-body border border-top-0 mb-2">
    <div class="row">
        <h4 class="fw-bold"> <i class="fa-solid fa-book"></i> Subject View</a></h4>
    </div>
    <hr>
    <?php foreach($subject as $i):?>
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <h5 class="fw-bold"><?=$i->subject_name?></h5>
                <p class="">Date created: <?=$i->subject_datecreated?></p>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <h5 class="fw-bold">Information</h5>
                <hr>
                <p><span class="fw-bold">Year/Grade-Level:</span> <?=$i->grade_title?></p>
                <p><span class="fw-bold">Description:</span> <?=$i->subject_description?></p>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>
</div>
</div>