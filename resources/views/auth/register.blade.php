@extends('layouts.app')
@section('title', 'Register')
@section('content')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
          <div class="login-brand">
          </div>

          <div class="card card-primary">
            <div class="card-header"><h4>Register</h4></div>

            <div class="card-body">
              <form method="POST" action="{{ route('register') }}">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                <div class="row">
                  <div class="form-group col-12">
                    <label for="frist_name">First Name</label>
                    <input id="frist_name" type="text" class="form-control" name="name" autofocus>
                  </div>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email">
                  <div class="invalid-feedback">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-6">
                    <label for="password" class="d-block">Password</label>
                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required autocomplete="new-password">
                    <div id="pwindicator" class="pwindicator">
                      <div class="bar"></div>
                      <div class="label"></div>
                    </div>
                  </div>
                  <div class="form-group col-6">
                    <label for="password2" class="d-block">Password Confirmation</label>
                    <input id="password2" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
                </div>


                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Register
                  </button>
                </div>
              </form>

              <!-- Social Login Section -->
              <div class="text-center mt-4 mb-3">
                <div class="text-job text-muted">Register With Social</div>
              </div>

              <div class="row">
                <div class="col-12">
                  <a href="{{ route('auth.google') }}" class="btn btn-lg btn-block d-flex align-items-center justify-content-center google-btn" style="background-color: #ffffff; border: 1px solid #dadce0; color: #3c4043; font-weight: 500; text-decoration: none; padding: 12px 24px; border-radius: 6px; transition: all 0.2s ease-in-out; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.15)'" onmouseout="this.style.backgroundColor='#ffffff'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <img src="{{ asset('images/google-logo.svg') }}" alt="Google" width="20" height="20" class="me-2" style="margin-right: 10px;">
                    Continue with Google
                  </a>
                </div>
              </div>

            </div>
          </div>
          <div class="mt-5 text-muted text-center">
            Don't have an account? <a href="{{ route('login') }}">Create One</a>
          </div>
          <div class="simple-footer">
            Copyright &copy; Demo 2018
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
