
const video = document.getElementById('video')

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('./assets/face-api/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('./assets/face-api/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('./assets/face-api/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('./assets/face-api/models'),
]).then(startVideo())

function startVideo(){

    if(!navigator.getUserMedia)
    {
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia || navigator.msGetUserMedia;
    }

    navigator.getUserMedia(
        {video: {} },
        stream => video.srcObject = stream,
        err => console.error(err)
    )

        
}

    
video.addEventListener('playing', () =>{
    const canvas = faceapi.createCanvasFromMedia(video)
    document.body.append(canvas)
    const displaySize = {width: video.width, height: video.height}
    setInterval(async () => {
        const detections = await faceapi.detectAllFaces(video,
        new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
        console.log(detections)
        const resizedDetections = faceapi.resizeResults(detections, displaySize)
        faceapi.draw.drawDetections(canvas, resizedDetections)
    }, 100)
})