<div class=" modalx container py-5 h-100 subject">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

                <div class="mb-md-5 mt-md-4 pb-5 form_repeat_l">
                    <div class="modal-header">
                        <button class="btn--close-modal subject_close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="thank-you-pop">
                            <img src="{{URL::asset("storage/image/modal/error.png")}}" width="150" alt="">
                            <br>
                            <br>
                            <h1 class="color_subject">ERROR</h1>
                            <hr>
                            <p class="color_subject">Mensaje :{{ __(session('error')) }}</p>
                         </div>
                    </div>
                <div>
            </div>
        </div>
    </div>
    </div>
</div>
