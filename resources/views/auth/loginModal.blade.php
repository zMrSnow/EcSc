<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prihlásiť sa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open( ['route' => 'auth.login', 'method' => 'post', 'class' => ''] ) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email( 'email', null, [
                        'class' => 'form-control',
                        'placeholder' => 'priklad@mail.hu',
                        'autofocus' => true,
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


                <label class="checkbox">
                    {!! Form::checkbox('remember', 'remember', true) !!}
                    Zapametať si ma
                </label>

                <div class="form-group">
                    {!! Form::button( 'Prihlásiť sa', [
                        'type' => 'submit',
                        'class' => 'btn btn-block btn-outline-success'
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
