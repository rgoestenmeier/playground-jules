<!DOCTYPE html>
<html>
<head>
    <title>YouTube Playlist</title>
    <style>
        body {
            font-family: sans-serif;
        }
        #player-container {
            margin-bottom: 20px;
        }
        #playlist {
            list-style: none;
            padding: 0;
        }
        #playlist li {
            cursor: pointer;
            display: flex;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        #playlist li:hover {
            background-color: #eee;
        }
        #playlist li img {
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <div id="player-container">
        <div id="player"></div>
    </div>

    <ul id="playlist">
        @foreach ($playlist as $video)
            <li data-id="{{ $video->id }}" data-start="{{ $video->start }}" data-stop="{{ $video->stop }}">
                <img src="{{ $video->image }}" alt="{{ $video->title }}" width="120">
                {{ $video->title }}
            </li>
        @endforeach
    </ul>

    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                videoId: '{{ $playlist[0]->id }}',
                playerVars: {
                    'playsinline': 1,
                    'start': {{ $playlist[0]->start }},
                    'end': {{ $playlist[0]->stop }}
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            event.target.playVideo();
        }

        var done = false;
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
                setTimeout(stopVideo, ({{ $playlist[0]->stop }} - {{ $playlist[0]->start }}) * 1000);
                done = true;
            }
        }
        function stopVideo() {
            player.stopVideo();
        }

        document.getElementById('playlist').addEventListener('click', function(e) {
            if (e.target && e.target.nodeName == "LI") {
                var id = e.target.getAttribute('data-id');
                var start = e.target.getAttribute('data-start');
                var stop = e.target.getAttribute('data-stop');
                player.loadVideoById({
                    videoId: id,
                    startSeconds: start,
                    endSeconds: stop
                });
                done = false;
            }
        });
    </script>
</body>
</html>
