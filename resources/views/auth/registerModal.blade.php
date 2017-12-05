<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Zaregistrovať sa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open( ['route' => 'auth.register', 'method' => 'post', 'class' => ''] ) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Meno:') !!}
                    {!! Form::text( 'name', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Vaše meno',
                        'required' => true,
                    ])
                    !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email( 'email', null, [
                        'class' => 'form-control',
                        'placeholder' => 'email@email.sk',
                        'required' => true,
                    ])
                    !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Heslo:') !!}
                    {!! Form::password( 'password', [
                        'class' => 'form-control',
                        'required' => true,
                    ]) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Heslo ešte raz:') !!}
                    {!! Form::password( 'password_confirmation', [
                        'class' => 'form-control',
                        'required' => true,
                    ]) !!}
                </div>

                <div class="form-group">
                    {!! Form::button( 'Zaregistrovať sa', [
                        'type' => 'submit',
                        'class' => 'btn btn-block btn-outline-danger'
                    ]) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavrieť</button>
            </div>
        </div>
    </div>
</div>