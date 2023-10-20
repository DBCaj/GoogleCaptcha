<div>
  <div class="card" style="max-width: 650px; margin-top: 20px;">
    <div class="card-header">
      <h3 class="text-georgia text-center">Register Form</h3>
    </div>  
     
    <div class="card-body">
      @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ Session::get('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      @if ($errors->has('g-recaptcha-response'))
          <span class="help-block alert alert-danger" role="alert">
                {{ $errors->first('g-recaptcha-response') }}
          </span>
      @endif
      
      <form action="{{ route('register.auth') }}" method="POST" style="margin-top:20px">
        @csrf
        <div class="form-group">
          <label for="lastname">Name: </label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
          @error('name')
            <span style="color:red">{{ $message }}. e.g., Doe</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Email: </label>
          <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
          @error('email')
            <span style="color:red">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password">Password: </label>
          <input type="password" name="password" class="form-control" required>
          @error('password')
            <span style="color:red">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirm Password: </label>
          <input type="password" name="password_confirmation" class="form-control" required>
          @error('password_confirmation')
            <span style="color:red">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="role">Role: </label>
            <select name="role" value="" class="form-control">
              <option value="user" selected>
                User
              </option>
              <option value="admin">
                Admin
              </option>
            </select>
          @error('role')
            <span style="color:red">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          {!! NoCaptcha::renderJs() !!}
          {!! NoCaptcha::display() !!}
        </div>
        <div class="form-group">
          <button type="reset" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all fields?')">Clear</button>
          <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to submit?')">
            Register
          </button>
        </div>
        <div class="form-group">
          <a href="{{ route('login.form') }}" class="btn btn-link" style="text-decoration:underline">Already had an account?</a>
        </div>
      </form>
    </div>
  </div>
</div>  
