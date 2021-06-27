<?php

namespace App\Http\Controllers;

use App\Events\ProcessVideo;
use App\Models\Videos;
use FFMpeg\Format\Audio\Aac;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Streaming\FFMpeg;
use Streaming\Representation;

class UploadController extends Controller
{
    public function process(Request $request){
        $request->validate([
            'videos' => 'required'
        ]);
        $newVideos = [];
        if($request->hasfile('videos')) {
            foreach ($request->file('videos') as $video) {
                $fileModel = new Videos();
                $fileName = time().'_'.$video->getClientOriginalName();
                $filePath = $video->storeAs('uploads', $fileName, 'public');
                $fileModel->filename = time().'_'.$video->getClientOriginalName();
                $fileModel->fileType = $video->getClientOriginalExtension();
                $fileModel->MIMEType = $video->getClientMimeType();
                $fileModel->directory = '/storage/' . $filePath;
                $fileModel->save();
                array_push($newVideos, $fileModel);
            }
        }

        ProcessVideo::dispatch($newVideos);
        return redirect()->back();
    }

    public function index() {
        $videos = Videos::whereNotNull('conversionStatus')->get();
        return view('playlist', compact('videos'));
    }

    public function play($id) {
        $video = Videos::find($id);
        $videos = Videos::whereNotNull('conversionStatus')->get();
        return view('play', compact('videos', 'video'));
    }
}
