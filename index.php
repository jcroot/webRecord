<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Video Recording | RecordRTC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/RecordRTC.js"></script>

</head>
<body>
<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <span class="card-text">Prueba de Vida</span>
        </div>
        <div class="card-body">
            <video controls autoplay playsinline></video>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-success" id="btn-start-recording">Empezar a grabar</button>
            <button class="btn btn-secondary" id="btn-stop-recording" disabled>Parar de grabar</button>
        </div>
    </div>
</div>

<script>
    var video = document.querySelector('video');
    var urlPath;

    function captureCamera(callback) {
        navigator.mediaDevices.getUserMedia({audio: true, video: true}).then(function (camera) {
            callback(camera);
        }).catch(function (error) {
            alert('Unable to capture your camera. Please check console logs.');
            console.error(error);
        });
    }

    function stopRecordingCallback() {
        video.src = video.srcObject = null;
        video.muted = false;
        video.volume = 1;
        urlPath = URL.createObjectURL(recorder.getBlob());
        video.src = urlPath;

        recorder.camera.stop();
        recorder.destroy();
        recorder = null;
    }

    var recorder; // globally accessible

    document.getElementById('btn-start-recording').onclick = function () {
        this.disabled = true;
        captureCamera(function (camera) {
            video.muted = true;
            video.volume = 0;
            video.srcObject = camera;

            recorder = RecordRTC(camera, {
                type: 'video/mp4'
            });

            recorder.startRecording();

            // release camera on stopRecording
            recorder.camera = camera;

            document.getElementById('btn-stop-recording').disabled = false;
        });
    };

    document.getElementById('btn-stop-recording').onclick = function () {
        this.disabled = true;
        recorder.stopRecording(stopRecordingCallback);
    };
</script>

</body>
</html>
<?php
