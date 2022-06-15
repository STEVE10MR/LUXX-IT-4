<div class="">
    <div class="modale container py-5 h-100 hidden edits" tabindex="-1" role="dialog" id="modalEdit{{$value->id}}" data-id="{{$value->id}}">
        <div class="row d-flex justify-content-center align-items-center h-100 form">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
                <button class="btn--close-modal modal-close" data-id="{{$value->id}}">&times;</button>
                <h2 class="fw-bold mb-2 text-uppercase">Restablecer contraseña</h2>
                    <br>
                <form method="POST" enctype="multipart/form-data" action="{{ route('user.reset_password')}}" >
                    @csrf
                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="delete">Escriba 'Confirmar' para restablecer la contraseña</label>
                        <input type="text" name="delete" id="delete" class="form-control form-control-lg" placeholder="Escriba 'CONFIRMAR'" required/>
                        @error('delete')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <input type="hidden" name="id" value="{{$value->id}}">
                    <br>
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Restablecer contraseña</button>
                </form>


                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
