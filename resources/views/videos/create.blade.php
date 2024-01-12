@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            {{ isset($video) ? 'تعديل فيديو' : 'انشاء فيديو'}}
        </div>
        <div class="card-body">
            <form action="{{  isset($video) ? route('videos.update', $video->id) : route('videos.store')  }}"
                  method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($video))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">العنوان</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ isset($video) ? $video->title : '' }}">
                    @if($errors->has('title'))
                        <span class="text-danger font-weight-bold">* {{$errors->first('title')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">وصف الفيديو</label>
                    <textarea name="description" id="description" cols="5" rows="5"
                              class="form-control">{{ isset($video) ? $video->description : '' }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger font-weight-bold">* {{$errors->first('description')}}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="video">رفع الفيديو</label>
                    <input type="file" id="video" name="video" class="form-control">
                    @if($errors->has('video'))
                        <span class="text-danger font-weight-bold">* {{$errors->first('video')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    @if(isset($video))
                        <video width="100%" height="50%" src="{{ asset('assets/Videos/'.$video->video) }}" controls muted></video>
                    @endif
                </div>

                <div class="form-group d-flex justify-content-center">
                    <button class="primary-btn transition"
                            data-text="{{ isset($video) ? 'تحديث الفيديو' : 'رفع الفيديو' }}">
                        <span>
                            {{ isset($video) ? 'تحديث الفيديو' : 'رفع الفيديو' }}
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
