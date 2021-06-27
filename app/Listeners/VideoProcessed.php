<?php

namespace App\Listeners;

use App\Events\ProcessVideo;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Monolog\Logger;
use Streaming\FFMpeg;
use Streaming\Representation;

class VideoProcessed implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProcessVideo  $event
     * @return void
     */
    public function handle(ProcessVideo $event)
    {
        foreach($event->videos as $video) {
            $file = storage_path() . '/app/public/uploads/' . $video->filename;
            $config = [
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/bin/ffprobe',
                'timeout'          => 3600,
                'ffmpeg.threads'   => 12,
            ];
            $log = new Logger('FFmpeg_Streaming');
            $r_720p  = (new Representation)->setKiloBitrate(2048)->setResize(640, 480);
            $ffmpeg = FFMpeg::create($config);
            $conversion = $ffmpeg->open($file);
            $videoConverted = time() . '.m3u8';
            $gif = '/m3u8/gifs/' .time(). '.gif';
            $conversion->hls()
                ->x264()
                ->addRepresentations([$r_720p])
                ->save(public_path() . '/m3u8/' . $videoConverted);
            $conversion->gif(TimeCode::fromSeconds(2), new Dimension(640, 480), 3)
                ->save(public_path() . $gif);
            $video->MIMETypeConverted = 'm3u8';
            $video->filename = $videoConverted;
            $video->conversionStatus = new \DateTime();
            $video->thumbnail = $gif;
            $video->save();
        }
        return true;
    }
}
