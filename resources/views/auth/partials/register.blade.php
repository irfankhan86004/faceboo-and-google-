
<form role="form" id="login" method="POST" action="{{ url('/register') }} ">
    {!! csrf_field() !!}
    <legend>Create Your Login</legend>
     <div class="form-group fg-line">
        <input type="text" class="form-control"
               name="username" value="{{ old('email') }}" placeholder="username" required>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
    </div>
    <div class="form-group fg-line">
        <input type="email" class="form-control"
               name="email" value="{{ old('email') }}" placeholder="Email" required>
                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
    </div>
    <div class="form-group fg-line">
        <input type="password" name="password" class="form-control"
               placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
    </div>
   <div class="form-group fg-line">
         <input id="password-confirm" type="password" class="form-control" name="confirmPassword"   placeholder="Password" required>
           @if ($errors->has('confirmPassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirmPassword') }}</strong>
                                    </span>
                                @endif
    </div>

    {{--<fieldset>--}}
        {{--<legend>Company Information (public)</legend>--}}
        {{--<div class="label-group form-group">--}}
            {{--<label for="company_name">--}}
                {{--Company Name*--}}
                {{--<input class="form-control" type="text" name="company_name" id="company_name" placeholder="Company Name" tabindex="5" required="" value="">--}}
            {{--</label>--}}

        {{--</div>--}}
        {{--<div class="label-group form-group">--}}
            {{--<label for="company_url">--}}
                {{--Company Webpage*--}}
                {{--<input class="form-control" type="text" name="url" id="company_url" placeholder="http://" tabindex="7" required="" value="">--}}
            {{--</label>--}}
            {{--<label for="company_logo">--}}
                {{--Logo <small>(130x130 is best, but any works)</small><br>--}}
                {{--<input class="large4col" type="file" name="company_logo" id="company_logo" placeholder="Logo" tabindex="8">--}}
            {{--</label>--}}
        {{--</div>--}}
    {{--</fieldset>--}}
    
    <button type="submit" name="submit" class="btn btn-primary btn-block m-t-10">Sign up</button>
    <hr>
      <a href="{{ route('auth.password.forgot') }}" class="btn btn-link btn-block m-t-10">Forgot my password</a>
</form>
