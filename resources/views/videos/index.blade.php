@extends('layouts.app')

@section('content')
    <div class="mb-3 mt-3 mt-lg-0">
        <a href="{{ route('videos.create') }}" class="primary-btn transition" data-text="اضافة فيديو">
            <span>اضافة فيديو</span>
        </a>
    </div>
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <i class="fa fa-video-camera fa-2x mr-3"></i>
            الفيديوهات
        </div>
        <div class="card-body">
            @if($videos->count() > 0)
                <table class="table videos-table">
                    <thead>
                    <tr>
                        <th>الفيديو</th>
                        <th>العنوان</th>
                        <th>الوصف</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($videos as $video)
                        <tr>
                            <td>
                                <video width="200px" height="150px" src="{{ asset('assets/Videos/'.$video->video) }}" controls muted></video>
                            </td>
                            <td>{{ $video->title }}</td>
                            <td>{{ $video->description }}</td>
                            @if($video->trashed())
                                <td>
                                    <form action="{{ route('restore-video', $video->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button class="primary-btn transition" data-text="استعادة">
                                            <span>استعادة</span>
                                        </button>
                                    </form>
                                </td>

                            @else
                                <td>
                                    <a href="{{ route('videos.edit', $video->id) }}" class="primary-btn transition"
                                       data-text="تعديل">
                                        <span>تعديل</span>
                                    </a>
                                </td>
                            @endif
                            <td>
                                <form action="{{ route('videos.destroy', $video->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="primary-btn transition red"
                                            data-text="{{ $video->trashed() ? 'ازالـة' : 'حذف' }}">
                                    <span>
                                        {{ $video->trashed() ? 'ازالة' : 'حذف' }}
                                    </span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <p>اظهار من {{ $videos->firstItem() }} لـ {{ $videos->lastItem() }} من أصل {{ $videos->total() }} فيديوهات</p>
                    <ul class="pagination pagination-sm justify-content-center">
                        <form class="form-inline" action="" method="get">
                            <div class="form-group">
                                <label for="perPage">عدد الفيديوهات في الصفحة</label>
                                <select class="form-control-sm ml-3 mr-3" name="perPage" id="perPage" onchange="this.form.submit()">
                                    <option value="5" @if($videos->perPage() == 5) selected @endif>5</option>
                                    <option value="10" @if($videos->perPage() == 10) selected @endif>10</option>
                                    <option value="15" @if($videos->perPage() == 15) selected @endif>15</option>
                                    <option value="20" @if($videos->perPage() == 20) selected @endif>20</option>
                                </select>
                            </div>
                            {{ $videos->appends(['perPage' => $videos->perPage()])->links() }}
                        </form>
                    </ul>
                </div>
                @else
                <h3 class="text-danger d-flex align-items-center justify-content-center">
                    <i class="fa fa-frown-o fa-2x mr-3"></i>
                    لا يوجد اي فيديوهات هنا
                </h3>
            @endif
        </div>
    </div>
@endsection
