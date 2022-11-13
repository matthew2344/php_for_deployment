<div class="main-content">


<?php foreach($user as $i): 
    $userID = $i->userID;
    $name = "$i->fname $i->mname $i->lname";
    endforeach;?>
<div class="row">
    <div class="card rounded">
        <div class="card-header d-flex justify-content-between">
            <h4 class="fw-bold">SUBMIT FACE TRAINING <span class="fw-light">(<?=$name?>)</span></h4>
            <a href="<?=base_url('security/face_data')?>">Go back</a>
        </div>
        <hr>
        <div class="card-body">
            <?php if(isset($_SESSION['upload_error'])):?>
                <div class="alert alert-danger">
                    <?=$_SESSION['upload_error']?>
                </div>
            <?php endif;?>
            <?php if(isset($_SESSION['upload_status'])):?>
                <div class="alert alert-success">
                    <?=$_SESSION['upload_status']?>
                </div>
            <?php endif;?>
            <div class="row">
                <?= form_open_multipart("security/upload_dataset/$userID") ?>
                <h5 class="text-center">UPLOAD IMAGE</h5>
                <input type="file" name="files[]"  multiple="" class="form-control mb-2">
                <button type="submit" class="btn btn-primary mb-5">SUBMIT UPLOAD</button>
                <?= form_close()?>
                <hr>
            </div>
        </div>
    </div>
</div>

<!-- Modal
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Capture Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="img rounded d-flex justify-content-center" style="width: 100%">
            <div class="rounded" id="my_camera" autoplay muted></div>
        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-success form-control" onclick="take_snapshot()">CAPTURE</button>
        </div>
        <div id="results" hidden></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<?php foreach($user as $i): $userID = $i->userID;
    endforeach;?>

<script type="text/javascript" src="<?=base_url()?>assets/js/webcam.min.js"></script>
<script defer>


</script>