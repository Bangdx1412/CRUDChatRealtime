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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Thêm</button>
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
                            <tr id="row{{$item->id}}">
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td><img src="{{$item->image}}" class="img-user" alt=""></td>
                                <td>{{$item->email}}</td>
                                <td>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate" data-bs-id="{{$item->id}}">Sửa</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="{{$item->id}}">Xóa</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>"
                </table>
            </div>
        </div>
    </div>

    
{{-- <!-- Modal --> --}}
      {{-- <!-- Modal ADD--> --}}
        <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalAddLabel">Modal title</h1>
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
        {{-- Modal Update --}}
        <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUpdateLabel">Sửa user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        <input type="hidden" name="" id="idUp">
                        <div class="mb-3">
                            <label for="nameUP">Name</label>
                            <input type="text" class="form-control" name="" id="nameUp">
                        </div>
                        <div class="mb-3">
                            <label for="imageUp">Image</label>
                            <input type="text" class="form-control" name="" id="imageUp">
                        </div>
                        <div class="mb-3">
                            <label for="emailUp">email</label>
                            <input type="email" class="form-control" name="" id="emailUp">
                        </div>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-warning" id="chinhSua">Chỉnh sửa</button>
            </div>
            </div>
        </div>
        </div>
        {{-- Modal Delete --}}
        <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDeleteLabel">Cảnh báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                       <p class="text-danger">Bạn muốn xóa không</p>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-warning" id="xoa">Xóa</button>
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
            let btnClose = document.querySelector("#modalAdd .btn-close");
            btnClose.click();
            refesh();
            
        })
    })

    Echo.channel('users')
        .listen('UserCreated',e =>{
            console.log(e.user.name);
            
            let tbody = document.querySelector(".table tbody");
            let ui = `
             <tr id="row${e.user.id}"> 
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
        .listen('UserUpdated',e =>{
            let tbody = document.querySelector(".table tbody");
            let tr = tbody.querySelector(`#row${e.user.id}`)
            let UI = `
                <td>${e.user.id}</td>
                    <td>${e.user.name}</td>
                    <td><img src="${e.user.image}" class="img-user" alt=""></td>
                    <td>${e.user.email}</td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate" data-bs-id="${e.user.id}">Sửa</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete" data-bs-id="${e.user.id}">Xóa</button>
                    </td>
            `
            tr.innerHTML = UI
        })
        .listen('UserDeleted',e =>{
            let tbody = document.querySelector(".table tbody");
            let tr = tbody.querySelector(`#row${e.user.id}`);
            tr.remove();
            
        })
        
    
</script>

<script type="module">
    const myModalEl = document.getElementById('modalUpdate')
    let idUp = document.getElementById('idUp');
    let nameUp = document.getElementById('nameUp');
    let emailUp = document.getElementById('emailUp');
    let imageUp = document.getElementById('imageUp');

    myModalEl.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        // console.log(id);

        axios.post('{{route("detailUser")}}',{id})
        .then(response=>{
            idUp.value = response.data.id;
            nameUp.value = response.data.name;
            emailUp.value = response.data.email;
            imageUp.value = response.data.image;
           
            
        })
    })
    const chinhSua = document.querySelector("#chinhSua");
    function refesh(){
        idUp.value = "";
            nameUp.value = "";
            emailUp.value = "";
            imageUp.value = "";
    }
    chinhSua.addEventListener('click',function(){
        console.log(123);
        
        let dataUpdate = {
            id: idUp.value,
            name: nameUp.value,
            image: imageUp.value,
            email: emailUp.value
        }
         axios.post('{{route("updateUser")}}',dataUpdate)
        .then(response=>{
            console.log(response);
            
            let btnClose = document.querySelector("#modalUpdate .btn-close");
            btnClose.click();
            refesh();
            
        })
    })
</script>
<script type="module">
    let myModalEl = document.getElementById("modalDelete")
    let idDelete;
      myModalEl.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-bs-id');
        // console.log(id);
        idDelete = id;
    })
    
      myModalEl.addEventListener('hidden.bs.modal', event => {
        idDelete = undefined;
    })
    function refesh() {
        idDelete = undefined
    }
    let xoa = document.querySelector("#xoa");
    xoa.addEventListener('click',function(){
         axios.post('{{route("deleteUser")}}',{
            id:idDelete
         })
        .then(response=>{
            console.log(response);
            
            let btnClose = document.querySelector("#modalDelete .btn-close");
            btnClose.click();
            refesh();
            
        })
    })
</script>
@stop