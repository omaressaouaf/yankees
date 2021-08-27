<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width : 700px" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="nav nav-tabs nav-fill" id="authTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab"
                            aria-controls="login" aria-selected="true">{{__('Login')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab"
                            aria-controls="register" aria-selected="false">{{__('Register')}}</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        @include('includes.login-form' , ['redirect_to_checkout' => true])
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        @include('includes.register-form' , ['redirect_to_checkout' => true])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
