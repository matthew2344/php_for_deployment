<div class="main-content">
    <div class="row">

        <div class="card rounded">

            <div class="card-header">
                <h4 class="fw-bold">Student <span class="fst-italic text-primary">Logs</span></h4>
                <hr>
            </div>

            <div class="card-body">
                <div class="row container">
                    <?php foreach($user as $i):?>
                        <h5>Student-ID: <?=$i->id?></h5>
                        <h5>Fullname: <?=$i->fname?> <?=$i->mname?> <?=$i->lname?></h5>
                    <?php endforeach;?>
                </div>

                <div class="card-content table-responsive">
                    <table class="table">
                        <thead class="bg-primary text-light">
                            <tr>
                                <td>DATE</td>
                                <td>TIME-IN</td>
                                <td>TIME-OUT</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($logs as $i):?>
                            <tr>
                                <td><?=$i->id?></td>
                                <td><?=$i->time_in?></td>
                                <td><?=$i->time_out?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>


            </div>

        </div>

    </div>