@extends('auth.contenido')

@section('login')

    <div class="container">
        <div class="row justify-content-md-center vertical-center">
            <div class="card-group login-card">
                <div class="card p-3" style="width: 25rem;">
                    <div class="card-body text-center py-5" style="vertical-align: middle;">
                    <div><p><img src="img/logo_login.png" alt="Login" ><br>sɪsᴛᴇᴍᴀ ᴅᴇ ᴄᴏɴᴛʀᴏʟ</p></div>     
                    </div>
                    <div class="row float-left text-muted text-small">
                        <div class="col-6"><em>by</em> ωнιτєѕнαяκ</div>
                    </div>                
                </div> 
                <div class="card p-3 bg-primary text-white" style="width: 25rem;">          
                    <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }} 
                        <div class="card-body">
                            <h1>Login</h1><p>Control de acceso al sistema</p>  
                            <div class="input-group input-group-sm mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>                          
                                <input id="usuario" type="text" class="form-control @error('usuario') is-invalid @enderror" name="usuario" value="{{ old('usuario') }}" required autocomplete="current-usuario" autofocus placeholder="Usuario">
                                @error('usuario')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div> 
                            <div class="input-group input-group-sm mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-unlock-alt" id="i_lock"></i></span>
                                </div>                           
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>   
                            <div class="input-group input-group-sm">                                 
                                <button type="submit" id="btn_login" class="btn btn-primary btn-xs px-4">Ingresar</button>                          
                            </div>
                        </div>  
                    </form>
                </div>        
            </div>
        </div>    
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
	$('#btn_login').click(function() {
        if ($('#usuario').val().length && $('#password').val().length) {
            $('#btn_login').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').addClass('disabled');
            $('#i_lock').removeClass('fas fa-unlock-alt');
            $('#i_lock').addClass('fas fa-lock');
        }
    });
    </script>
@endpush
