<style>
.card-img{
    width: 100%;
    border-radius: calc(0.25rem -1px);
}
.card-img img{
    padding-top: 10px;
    width: inherit;
    height: 180px;
    object-fit: contain;
    display: block;
}

</style>

<div class="main-content">
    <div class="row">
        <div class="card rounded">
            <div class="card-header">
                <?php if(isset($_SESSION['upload_error'])):?>
                  <div class="alert alert-danger">
                     <?= $_SESSION['upload_error']; ?>
                  </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['upload_status'])):?>
                  <div class="alert alert-danger">
                     <?= $_SESSION['upload_status']; ?>
                  </div>
                <?php endif; ?>
                <a href="<?=base_url('Admin/go_back')?>"><span class="material-icons">arrow_back_ios</span></a>
                <h4 class="fw-bold mt-3">Manage Dataset (<span class="text-primary"><?=$fname?> <?=$lname?></span>)</h4>
            </div>
            <div class="card-body">
                <h3 class="fw-bold text-primary text-center">Upload Files</h3>
                <div class="d-flex justify-content-center p-5 rounded bg-light mx-5">
                    <?=form_open_multipart('Admin/upload_dataset/'.$uid,array('class'=> ''))?>
                        <label for="" class="form-label" id="uploadFile">Upload Files</label>
                        <input type="file" name="files[]" id="" multiple="" class="form-control">
                </div>
                <div class="text-center mx-5">
                    <button type="submit" class="btn btn-primary form-control">UPLOAD</button>
                    <?=form_close()?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="fw-bold">Face Dataset</h4>
            </div>
            <div class="card-body d-flex flex-wrap">
                <?php foreach($face_data as $i):?>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-4 m-3 rounded">
                        <div class="card d-flex flex-column align-items-center shadow-lg">
                            <div class="card-img">
                                <img src="<?=base_url()?>dataset/<?=$fname?>_<?=$lname?>/<?=$i->img_path?>" alt="">
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold">
                                        <a href="<?=base_url('Admin/delete_file/')?><?=$fname?>_<?=$lname?>/<?=$i->id?>">
                                            <span class="material-icons" style="font-size: 2rem;">
                                                delete
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <p><?=$pagination?></p>
            <p><?=print_r($face_data)?></p>
        </div>
    </div>