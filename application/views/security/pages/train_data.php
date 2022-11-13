<div class="main-content">
    
<div class="row">
    <div class="card rounded">
        <div class="card-header">
            <h4 class="fw-bold">FACE TRAINING</h4>
        </div>
        <hr>
        <div class="card-body">
            <?php if(isset($_SESSION['ERROR_TRAINING'])):?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('ERROR_TRAINING')?>
                </div>
            <?php endif;?>
            <?php if(isset($_SESSION['TRAINING'])):?>
                <div class="alert alert-warning" id="get_response">
                    <?= $this->session->flashdata('TRAINING')?>
                </div>
            <?php endif;?>
            <div class="row">
                <div class="col-12">
                    <a href="<?=base_url('Security/train_data')?>" class="btn btn-primary">TRAIN FACE DATA</a>
                </div>
            </div>
            
            <div class="d-flex flex-md-row  flex-sm-row flex-column justify-content-between flex-wrap p-2">
                <a href="" class="mt-2">Student list</a>
                <a href="" class="mt-2">Teachers list</a>
                <a href="" class="mt-2">Non-teaching Staff list</a>
            </div>


            <div class="row">
                <div class="card-content table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="bg-primary text-light">
                                <td>School ID</td>
                                <td>Full Name</td>
                                <td>Role</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($Users as $i):?>
                                <tr>
                                    <td><?=$i->userID?></td>
                                    <td><?=$i->fname?> <?=$i->mname?> <?=$i->lname?></td>
                                    <td><?=$i->role?></td>
                                    <td><a href="<?=base_url("Security/face_submission/$i->userID")?>" class="btn btn-primary">ADD IMAGE</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?=$pagination?>
                </div>
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