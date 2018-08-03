<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>lee-voice</title>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        html,body{
            background: #fff;
        }
        .btn{
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 150px;
            background: #eee;
        }
        .btn input{
            width: 100%;
            height: 100%;
            font: 50px/150px 'microsoft yahei';
        }
        ul { list-style: none; }
        #recordingslist audio { display: block; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="btn">
    <ul id="recordingslist"></ul>
    <input type="button" name="" id="messageBtn" value="按住 说话">
</div>
<script type="text/javascript">
    function __log(e, data) {
        log.innerHTML += "\n" + e + " " + (data || '');
    }

    var audio_context;
    var recorder;

    function startUserMedia(stream) {
        var input = audio_context.createMediaStreamSource(stream);
        // __log('Media stream created.');

        // Uncomment if you want the audio to feedback directly
        //input.connect(audio_context.destination);
        //__log('Input connected to audio context destination.');

        recorder = new Recorder(input);
        // __log('Recorder initialised.');
    }

    function startRecording(button) {
        recorder && recorder.record();
        button.disabled = true;
        button.nextElementSibling.disabled = false;
        __log('Recording...');
    }

    function stopRecording(button) {
        recorder && recorder.stop();
        button.disabled = true;
        button.previousElementSibling.disabled = false;
        __log('Stopped recording.');

        // create WAV download link using audio data blob
        createDownloadLink();

        recorder.clear();
    }

    function createDownloadLink() {
        recorder && recorder.exportWAV(function(blob) {
            var url = URL.createObjectURL(blob);
            var li = document.createElement('li');
            var au = document.createElement('audio');
            var hf = document.createElement('a');

            au.controls = true;
            au.src = url;
            hf.href = url;
            hf.download = new Date().toISOString() + '.wav';
            hf.innerHTML = hf.download;
            li.appendChild(au);
            li.appendChild(hf);
            recordingslist.appendChild(li);
        });
    }

    window.onload = function init() {
        try {
            // webkit shim
            window.AudioContext = window.AudioContext || window.webkitAudioContext;
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
            window.URL = window.URL || window.webkitURL;

            audio_context = new AudioContext;
            // __log('Audio context set up.');
            // __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
        } catch (e) {
            alert('No web audio support in this browser!');
        }

        navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
            // __log('No live audio input: ' + e);
        });
    };


    var btnElem=document.getElementById("messageBtn");//获取ID
    var posStart = 0;//初始化起点坐标
    var posEnd = 0;//初始化终点坐标
    var posMove = 0;//初始化滑动坐标
    console.log(screen);
    function initEvent() {
        btnElem.addEventListener("touchstart", function(event) {
            event.preventDefault();//阻止浏览器默认行为
            posStart = 0;
            posStart = event.touches[0].pageY;//获取起点坐标
            btnElem.value = '松开 结束';
            recorder && recorder.record();
            console.log("start");
            console.log(posStart+'---------开始坐标');
        });
        btnElem.addEventListener("touchmove", function(event) {
            event.preventDefault();//阻止浏览器默认行为
            posMove = 0;
            posMove = event.targetTouches[0].pageY;//获取滑动实时坐标
            if(posStart - posMove < 500){
                btnElem.value = '松开 结束';
            }else{
                btnElem.value = '松开手指，取消发送';
            }
            /*console.log(posStart+'---------');
            console.log(posMove+'+++++++++');*/
        });
        btnElem.addEventListener("touchend", function(event) {
            event.preventDefault();
            posEnd = 0;
            posEnd = event.changedTouches[0].pageY;//获取终点坐标
            btnElem.value = '按住 说话';
            console.log("End");
            console.log(posEnd+'---------结束坐标');
            if(posStart - posEnd < 500 ){
                console.log("发送成功");
                save();
            }else{
                console.log("取消发送");
                console.log("Cancel");
            };
        });
    };
    initEvent();
    function save(){
        recorder && recorder.stop();
        // create WAV download link using audio data blob
        createDownloadLink();

        recorder.clear();
        //ajax
        console.log('Success');
    }
</script>
<script src="/js/recorder.js"></script>

</body>
</html>





