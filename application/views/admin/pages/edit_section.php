<div class="main-content">
    <?php foreach($section_data as $i):?>
        <div class="row">
            <div class="card rounded">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="fw-bold">Edit Section</h4>
                    <a href="<?=base_url('Admin/manage_section')?>">Go back</a>
                </div>
                <hr>
                <div class="card-body">
                    <?= form_open("Admin/update_section/".$i->sectionID);?>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 mb-2">
                            <label for="">Section Name</label>
                            <input type="text" name="name" class="form-control mt-2 <?php if(form_error('name')) echo 'is-invalid';?>" value="<?=$i->sectionName?>">
                            <div class="invalid-feedback">
                                <?php 
                                    echo form_error('name');
                                ?>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary">
                    <?= form_close();?>
                </div>
            </div>
        </div>
    <?php endforeach;?>

    