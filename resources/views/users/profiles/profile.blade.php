@extends('users.profiles.index')
@section('tab-pane')

<div class="tab-pane active" id="profile">
    <h6>
      INFORMACIÓN DE SU PERFIL</h6>
    <hr>
    <form method="POST" enctype="multipart/form-data" action="{{route('user.update_profile')}}">
      @csrf
      <div class="form-group">
        <label for="fullName">Nombre completo</label>
        <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="fullNameHelp" placeholder="Enter your fullname"  value="{{old('fullname',$user->name)}}">
        <small id="fullNameHelp" class="form-text text-muted">
          Su nombre puede aparecer por aquí donde se le menciona. Puede cambiarlo o eliminarlo en cualquier momento.</small>
      </div>
      <div class="form-group">
        <label for="phone">Telefono</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone',$user->phone)}} ">
      </div>
      <div class="form-group">
        <label for="image">Imagen de Perfil</label>
        <input type="file" name="image" id="image" accept="image/jpg, image/jpeg, image/png"/>
      </div>
      <div class="form-group">
       </div>
      <br>
      <button class="btn active_upd">Actualizar Perfil</button>
    </form>
</div>

@endsection




