@if (session('success_message'))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><i class="fa fa-check-circle text-white"></i></strong> {{ session('success_message') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><i class="fa fa-times-circle text-white"></i></strong> {{ __('front.errorMessage') }}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
