@extends('layouts.app')
@section('style')
<style>
    .img-user{
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>name</th>
                            <th>image</th>
                            <th>Email</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td><img src="{{$item->image}}" class="img-user" alt=""></td>
                                <td>{{$item->email}}</td>
                                <td>
                                    <button class="btn btn-warning">Sửa</button>
                                    <button class="btn btn-danger">Xóa</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
<!-- Modal -->
      <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="text" class="form-control" name="" id="image">
                        </div>
                        <div class="mb-3">
                            <label for="email">email</label>
                            <input type="email" class="form-control" name="" id="email">
                        </div>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="themMoi">Tạo mới</button>
            </div>
            </div>
        </div>
        </div>
@stop

@section('script')
<script type="module">
    let themMoi = document.querySelector("#themMoi");
    let name = document.querySelector("#name");
    let image = document.querySelector("#image");
    let email = document.querySelector("#email");

    function refesh(){
        name.value = "";
        image.value = "";
        email.value = ""
    }

    themMoi.addEventListener('click',e =>{
        let data ={
            name: name.value,
            image: image.value,
            email: email.value
        }
        // console.log(data);
        axios.post('{{route("addUSer")}}',data)
        .then(response=>{
            let btnClose = document.querySelector("#exampleModal .btn-close");
            btnClose.click();
            refesh();
            
        })
    })

    Echo.channel('users')
        .listen('UserCreated',e =>{
            console.log(e.user.name);
            
            let tbody = document.querySelector(".table tbody");
            let ui = `
             <tr>
                <td>${e.user.id}</td>
                <td>${e.user.name}</td>
                <td><img src="${e.user.image}" class="img-user" alt=""></td>
                <td>${e.user.email}</td>
                <td>
                    <button class="btn btn-warning">Sửa</button>
                    <button class="btn btn-danger">Xóa</button>
                </td>
            </tr>
            `
            tbody.insertAdjacentHTML('afterbegin',ui)
        })
        
    
</script>
@stop