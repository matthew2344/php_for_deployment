<div class="card-body border border-top-0 mb-2">
   <div class="row mb-4">
      <h4 class="fw-bold"><span class="material-symbols-outlined">familiar_face_and_zone</span> Take Face Photo</h4>
   </div>
   <hr>
   <div class="row">
        <div class="d-flex justify-content-center mb-4">
            <div id="my_camera">
                
            </div>

        </div>
        <div id="results" style="visibility:hidden; position:absolute" class="">
        
        </div>
        <div class="d-flex justify-content-center">

            <button class="btn btn-primary" onclick="saveSnap()"><i class="fa-solid fa-camera"></i> Snap</button>
        </div>
   </div>
   <hr>
   <div class="row mt-4">
        <h4 class="fw-bold"><i class="fa-solid fa-upload"></i> Upload Image File</h4>
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
        <?php foreach($user as $i):?>
        <div class="row">
            <?= form_open_multipart("http://localhost:8000/upload_face/$i->userID") ?>
            <h5 class="text-center">UPLOAD IMAGE</h5>
            <input type="file" name="file[]"  multiple="" class="form-control mb-2">
            <input type="text" name="link" id="" value="<?=$this_link?>" hidden>
            <button type="submit" class="btn btn-primary mb-5">SUBMIT UPLOAD</button>
            <?= form_close()?>
            <hr>
        </div>
        <?php endforeach?>
   </div>

</div>


<script src="<?=base_url('assets/js/webcam.min.js')?>"></script>
<script defer>
    function configure(){
        Webcam.set({
            width: 480,
            height:360,
            image_format: 'jpeg',
            jpeg_quality: 100
        });


        Webcam.attach('#my_camera');
    }

    function saveSnap()
    {
        Webcam.snap(function(data_uri){
            document.getElementById('results').innerHTML = 
         '<img id="webcam" src="'+data_uri+'">';
        });

        <?php foreach($user as $i):?>
        var base64image = document.getElementById("webcam").src;
        // Webcam.upload(base64image, '<?=base_url('Admin/capture/'.$i->userID)?>', function(code,text){
        //     alert('Save success');
        // });
        $.ajax({
            url: `http://localhost:8000/upload_images/${<?=$i->userID?>}`,
            type: 'post',
            data: { image:base64image},
            success:function(response){
                toDataURL(`http://localhost:8000/upload_images/${<?=$i->userID?>}`, function(dataurl){
                    // console.log('RESULT:', dataurl)
                    image_source.src = dataurl;
                    get()
                })
            }
        });

        <?php endforeach?>
    }

    configure()
</script>