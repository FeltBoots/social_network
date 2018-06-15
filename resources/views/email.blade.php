
<h1>Click the Link To Verify Your Email</h1>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
Click the following link to verify your email {{url('/verifyemail/'.$email_token)}}