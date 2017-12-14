@if(count($errors) > 0)
    @forelse($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ooops nastala chyba!</strong> {{$error}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @empty
    @endforelse

@endif
@if(session('msg'))
    <div class="alert alert-success" role="alert">
        <strong>Oznam!</strong> {{session('msg')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-dark">&times;</span>
        </button>
    </div>
    @php  Session::forget("msg")  @endphp
@endif
@if(session('msgDanger'))
    <div class="alert alert-danger" role="alert">
        <strong>Ooops nastala chyba!</strong> {{session('msgDanger')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-dark">&times;</span>
        </button>
    </div>
    @php  Session::forget("msgDanger")  @endphp
@endif