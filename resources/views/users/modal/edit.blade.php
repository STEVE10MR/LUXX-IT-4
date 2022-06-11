<div class="">
    <div class="modale container py-5 h-100 hidden edits" tabindex="-1" role="dialog" id="modalEdit{{$value->id}}" data-id="{{$value->id}}">
        <div class="row d-flex justify-content-center align-items-center h-100 form">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
                <button class="btn--close-modal modal-close" data-id="{{$value->id}}">&times;</button>
                <h2 class="fw-bold mb-2 text-uppercase">Editar Producto</h2>
                    <br>
                <form method="POST" enctype="multipart/form-data" action="{{ route('product.update',$value->id)}}" >
                    @csrf
                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="name">Nombre de Producto</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{($value->name)}}" required/>
                        @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="description">Descripcion de Producto</label>
                        <input type="text" name="description" id="description" class="form-control form-control-lg" value="{{($value->descripcion)}}" required/>
                        @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="prices">Precio</label>
                        <input type="text" name="prices" id="prices" class="form-control form-control-lg" value="{{($value->price)}}" required/>
                        @error('prices')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-outline form-white mb-4">
                        <label class="form-label" for="category_id">Categoria</label>
                        <select name="category_id" class="form-control">
                            <option value="{{$value->cat_id}}">{{$value->category}}</option>
                            @forelse ($category as $categorys)
                                @if (!($value->cat_id == $categorys->id))
                                    <option value="{{$categorys->id}}">{{$categorys->category}}</option>
                                @endif
                            @empty
                                <option value="">Ninguna categoria</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="form-outline form-white mb-4">

                        <label class="form-label" for="image">Imagen de Producto</label>
                        <br>
                        <img src="{{URL::asset("storage/$value->portada")}}" class="img-edit" alt="Imagen de Producto" >
                    </div>
                    <div class="form-outline form-white mb-4">

                        <label class="form-label" for="image">Actualizar Imagen de Producto</label>
                        <input class="form-control" type="file" name="image" id="image" accept="image/jpg, image/jpeg, image/png"/>
                        @error('images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <br>
                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Editar</button>
                </form>


                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
