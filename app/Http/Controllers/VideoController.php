<?php

namespace App\Http\Controllers;

use App\Http\Requests\Videos\CreateVideoRequest;
use App\Http\Requests\Videos\UpdateVideoRequest;
use App\Video;

class VideoController extends Controller
{
    //
    public function index()
    {
        $videos = Video::orderBy('created_at', 'Desc')->paginate(request('perPage', 5));
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.create');
    }

    public function store(CreateVideoRequest $request)
    {
        $input = $request->all();
        $file = $request->file('video');
        if (file_exists($file)) {
            $name = preg_replace('/\s+/', '_', time() . '_' . $file->getClientOriginalName());
            $file->move('assets/Videos', $name);
            $input['video'] = $name;
        }
        Video::create($input);
        session()->flash('success', 'تم انشاء الفيديو بنجاح');

        return redirect()->route('videos');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('videos.create', compact('video'));
    }

    public function update(Video $video, UpdateVideoRequest $request)
    {
        $input = $request->only(['title', 'description', 'published_at']);
        $file = $request->file('video');
        if ($request->hasFile('video')) {
            $oldVideo = 'assets/Videos/' . $video->video;
            if (file_exists($oldVideo)) {
                unlink($oldVideo);
            }
            $name = preg_replace('/\s+/', '_', time() . '_' . $file->getClientOriginalName());
            $file->move('assets/Videos', $name);
            $input['video'] = $name;
        }
        $video->update($input);
        session()->flash('success', 'تم تحديث الفيديو بنجاح');
        return redirect()->route('videos');

    }

    public function destroy($id)
    {
        $video = Video::withTrashed()->whereId($id)->first();
        if ($video->trashed()) {
            $oldVideo = 'assets/Videos/' . $video->video;
            if (file_exists($oldVideo)) {
                unlink($oldVideo);
            }
            $video->forceDelete();
        } else {
            $video->delete();
        }
        session()->flash('success', 'تم حذف الفيديو بنجاح');
        return redirect()->route('videos');
    }

    public function trashed()
    {
        return view('videos.index')->with('videos', Video::onlyTrashed()->paginate(request('perPage', 5)));
    }

    public function restore($id)
    {
        $video = Video::withTrashed()->where('id', $id)->first();
        $video->restore();
        session()->flash('success', 'تم استعادة الفيديو بنجاح');
        return redirect()->route('videos');
    }
}
