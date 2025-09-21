@extends('layouts.app')

@section('style')
<style>
  /* Khung danh sách users */
.box-users {
    max-height: 550px;
    overflow-y: auto; /* Cho phép cuộn dọc */
    border-right: 1px solid #ddd;
    padding: 10px;
    background: #f9f9f9;
}

/* Khung mỗi user */
.box-user {
    width: 100%;
}

/* Item user */
.item {
    display: flex;
    align-items: center;
    padding: 8px;
    border-bottom: 1px solid #e0e0e0;
    transition: background 0.2s;
    position: relative;
}

.item:hover {
    background: #f1f1f1;
}
.item > a{
    align-items: center;
    text-decoration: none;
}
.item img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}

.item p {
    margin: 0;
    font-size: 14px;
    font-weight: 500;
}

/* Khung chat chính */
.box-chat {
    display: flex;
    flex-direction: column;
    height: 550px;
    padding: 0;
}

/* Danh sách tin nhắn */
.box {
    flex: 1; /* chiếm hết chiều cao còn lại */
    border: 1px solid #ddd;
    padding: 10px;
    overflow-y: auto;
    background: #fff;
    list-style: none;
    margin: 0;
    height: 500px;
}

/* Form nhập tin nhắn */
.box-chat form {
    display: flex;
    border-top: 1px solid #ddd;
    padding: 8px;
    background: #f9f9f9;
}

.box-chat input[type="text"] {
    flex: 1;
    margin-right: 8px;
}
.status{
    width: 20px;
    height: 20px;
    background: green;
    border-radius: 50%;
    position: absolute;
    left: 12px;
    bottom: 10px
}

</style>
@endsection
@section('content')
    <div class="container">
        <div class="row border">
            <div class="col-md-3 box-users">
                <div class="row">
                    <div class="col-md-12 box-user border" >
                        @foreach ($users as $item)
                           <div class="item">
                                <a href="" id="link_{{$item->id}}" class="d-flex" >
                                    <img style="width: 50px;" src="{{$item->image}}" alt="">
                                    <p>{{$item->name}}</p>
                                    {{-- <div class="status"></div> --}}
                                </a>
                           </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9 box-chat">
                <div class="row">
                    <ul class="box"></ul>
                    <form class="d-flex">
                        <input type="text" id="message" class="form-control" id="">
                        <button class="btn btn-primary" id="send" type="button">Gửi</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@stop

@section('script')
    <script type="module">
        Echo.join('nguoiOnline')
        .here(users=>{
            // Tất cả các user trong kênh có thể lấy hết ra
            // ví dụ có 50 người mà mình là người thứ 51 thì khi mình vào kênh chat 
            // Nó sẽ lấy ra hiển thị 50 ông có trong kênh chat kia
            console.log(users);
            users.forEach(user => {
                // user.id là các user trong kênh chat đã đăng nhập vào
                let elm = document.querySelector(`#link_${user.id}`);
                
                
                let divShowStatus = document.createElement("div");
                divShowStatus.classList.add("status");
                if(elm){
                    elm.appendChild(divShowStatus);
                }
              
            });
            
        })
        .joining(user=>{
            // Khi 1 user join vào kênh chat
            let elm = document.querySelector(`#link_${user.id}`);
            let divShowStatus = document.createElement("div");
                divShowStatus.classList.add("status");
                if(elm){
                    elm.appendChild(divShowStatus);
                }
            
        })
        .leaving(user=>{
            // Khi 1 user out kênh chat
            let elm = document.querySelector(`#link_${user.id}`);
            let divShowStatus = document.querySelector(".status");
            if(elm){
                elm.removeChild(divShowStatus);
            }
        })
        .listen('UserOnline',e=>{

        })
    </script>
@stop