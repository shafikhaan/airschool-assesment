<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>My Videos</title>
    <link href="https://vjs.zencdn.net/7.7.6/video-js.css" rel="stylesheet" />
    <!-- For IE8 (for Video.js versions prior to v7)
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    -->
</head>
<body>
<div class="main">
    <div class="player" style="width: 50%; margin: 0 auto;">
        <video-js id="videoPlayer" class="vjs-default-skin" controls preload="auto" width="640" height="268">
            <source src="{{ $videos->first() ? asset('m3u8/' . $videos->first()->filename) : "" }}" type="application/x-mpegURL">
        </video-js>
    </div>
    <div class="thumbnails" style="margin-top: 15px">
        @foreach($videos as $video)
            <a href="{{ route('play', $video->id) }}">
                <img height="150" width="150" src="{{ $video ? asset($video->thumbnail) : "" }}">
            </a>
        @endforeach
    </div>
</div>
<script src="https://unpkg.com/video.js/dist/video.js"></script>
<script src = "https://unpkg.com/browse/@videojs/http-streaming@1.13.3/dist/videojs-http-streaming.min.js"></script>
<script>
    var player = videojs('videoPlayer');
</script>
</body>
</html>
