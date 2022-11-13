
<div class="container d-flex justify-content-center">
    <div class="di">

        <div id="my_camera">
    
        </div>
        <br>
        <div id="results" style="visibility:hidden; position:absolute">
    
        </div>
        <br>
        <button onclick="saveSnap()">Save</button>

    </div>
</div>




<!-- <script type="text/javascript" src=”https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js ”></script> -->
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


        var base64image = document.getElementById("webcam").src;
        // Webcam.upload(base64image, 'http://localhost:8000/image', function(code,text){
        //     alert('Save success');
        // });
        $.ajax({
            url: 'http://localhost:8000/image',
            type: 'post',
            data: { image:base64image},
            success:function(response){
              console.log(response);
                
            }
          });

    }

    function get()
    {
        $.ajax({
            url: 'http://localhost:8000/message',
            type: 'get',
            success:function(response){
                console.log(response[0])
            }
          });
    }

    get()


    configure()
</script>













































<!-- <style>
    #video {
  border: 1px solid black;
  box-shadow: 2px 2px 3px black;
  width: 640px;
  height: 540px;
}

#photo {
  border: 1px solid black;
  box-shadow: 2px 2px 3px black;
  width: 320px;
  height: 240px;
}

#canvas {
  display: none;
}

/* .camera {
  width: 340px;
  display: inline-block;
}

.output {
  width: 340px;
  display: inline-block;
  vertical-align: top;
} */

#startbutton {
  display: block;
  position: relative;
  margin-left: auto;
  margin-right: auto;
  bottom: 32px;
  background-color: rgba(0, 150, 0, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.7);
  box-shadow: 0px 0px 1px 2px rgba(0, 0, 0, 0.2);
  font-size: 14px;
  font-family: "Lucida Grande", "Arial", sans-serif;
  color: rgba(255, 255, 255, 1);
}

.contentarea {
  font-size: 16px;
  font-family: "Lucida Grande", "Arial", sans-serif;
  width: 760px;
}

</style>

<div class="container d-flex mt-5 justify-content-center">
    <!-- <img id="face_recog" src="http://localhost:8000/vid" alt=""> -->
    <!-- <div class="camera">
        <video id="video">Video stream not available.</video>
        <button id="startbutton">Take photo</button>
    </div>
</div>
<div class="row">
    <?=form_open('http://localhost:8000/click')?>
        <button class="btn btn-success" type="submit" value="Capture" name="click">CAPTURE</button>
    <?=form_close()?>
</div> -->










































<script defer>
// function startVideo(){

// if(!navigator.getUserMedia)
// {
//     navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
//     navigator.mozGetUserMedia || navigator.msGetUserMedia;
// }

// navigator.getUserMedia(
//     {video: {} },
//     stream => video.srcObject = stream,
//     err => console.error(err)
// )

    
// }

// startVideo();
</script>


<!-- <script defer>
(() => {
  // The width and height of the captured photo. We will set the
  // width to the value defined here, but the height will be
  // calculated based on the aspect ratio of the input stream.

  const width = 320; // We will scale the photo width to this
  let height = 0; // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  let streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  let video = null;
  let canvas = null;
  let photo = null;
  let startbutton = null;

  function showViewLiveResultButton() {
    if (window.self !== window.top) {
      // Ensure that if our document is in a frame, we get the user
      // to first open it in its own tab or window. Otherwise, it
      // won't be able to request permission for camera access.
      document.querySelector(".contentarea").remove();
      const button = document.createElement("button");
      button.textContent = "View live result of the example code above";
      document.body.append(button);
      button.addEventListener('click', () => window.open(location.href));
      return true;
    }
    return false;
  }

  function startup() {
    if (showViewLiveResultButton()) { return; }
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton');

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
      .then((stream) => {
        video.srcObject = stream;
        video.play();
      })
      .catch((err) => {
        console.error(`An error occurred: ${err}`);
      });

    video.addEventListener('canplay', (ev) => {
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);

        // Firefox currently has a bug where the height can't be read from
        // the video, so we will make assumptions if this happens.

        if (isNaN(height)) {
          height = width / (4/3);
        }

        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        streaming = true;
      }
    }, false);

    startbutton.addEventListener('click', (ev) => {
      takepicture();
      ev.preventDefault();
    }, false);

    clearphoto();
  }

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    const context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    const data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }

  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {
    const context = canvas.getContext('2d');
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);

      const data = canvas.toDataURL('image/png');
      photo.setAttribute('src', data);
    } else {
      clearphoto();
    }
  }

  // Set up our event listener to run the startup process
  // once loading is complete.
  window.addEventListener('load', startup, false);
})();

</script> -->