@extends('layouts.app')

@section('content')
<div class="container">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createGroupChat">Tạo nhóm</button>
    <div class="row mb-3">
        <div class="col-md-6">
            <h4>Nhóm của bạn</h4>
            <ul>@foreach ($myGroup as $item)
                
                <li>
                    <a href="{{route('chatGroup',$item->id)}}">{{$item->name}}</a>
                </li>
            @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h4>Nhóm bạn làm thành viên</h4>
            <ul>
                @foreach ($myGroupNotLeader as $item)
                    <li>
                        <a href="{{route('chatGroup',$item->groupchatID)}}">{{$item->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
      </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<form action="{{route('createGroupChat')}}" method="POST">
    @csrf
    <div class="modal fade" id="createGroupChat" tabindex="-1" aria-labelledby="createGroupChatLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createGroupChatLabel">Tạo nhóm chat</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="mb-3">
            <label for="name">Tên nhóm</label>
            <input type="text" name="tenNhom" id="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="leader">Trưởng nhóm</label>
            <input type="text" name="leader" id="leader" class="form-control" value="{{Auth::user()->name}}" disabled>
        </div>
        <div class="mb-3">
            <label for="member">Thành viên</label>
            <select name="member[]" id="member" class="form-control" multiple style="min-height: 400px">
                @foreach ($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="submit" class="btn btn-primary">Tạo nhóm</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section('script')
    <script type="module">
        Echo.channel("thongBao").listen("UserSesstionChange",e =>{
            console.log({e});
            const thongBao = document.querySelector('#notification');
            thongBao.innerText = e.user;
            thongBao.classList.remove("invisible");
            thongBao.classList.remove("alert-success");
            thongBao.classList.remove("alert-danger");
            thongBao.classList.add('alert-'+ e.type)
            
        })
    </script>
    
@endsection