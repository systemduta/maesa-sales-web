<html>
    <body>
        <div class="floating-box">
            <div class="pic-container">
                <img class="pic" src="https://bit.ly/fcc-relaxing-cat" alt="A cute orange cat lying on its back.">
            </div>
            <div class="field-container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" id="email" name="email" placeholder="Email" required 
                        oninvalid="this.setCustomValidity('Please enter your email.')"
                        oninput="this.setCustomValidity('')">
                    <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" placeholder="Password" required 
                        oninvalid="this.setCustomValidity('Please enter your password.')"
                        oninput="this.setCustomValidity('')">
                    <div style="text-align:center;">
                        <input type="submit" value="Sign In">
                    </div>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <!-- <p>{{ $errors->first('email') }}</p> -->
                            <p>Invalid email or password.</p>
                        </span>
                    @endif
                    
                </form>
            </div>
            <div class="forget-pass">
                <a class="forget-pass" href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
           
        </div>
    </body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

    body{
        display:flex;
        background:rgba(128, 128, 128, 0.3);
        justify-content:center;
    }

    .floating-box{
        display: flex;
        width: 20rem;
        height: 20rem;
        background: #FFFFFF;
        border-radius: 1rem;
        align-self: center;
        flex-direction:column;
        padding: 2rem 2rem;
    }

    .pic-container{
        display: flex;
        height: 35%;
        width: 100%;
        justify-content:center;
    }

    .pic{
        border-radius:50%;
    }

    .field-container{
        margin-top: 1rem;
        margin-bottom: 1rem;
        display: flex;
        height: 55%;
        width: 100%;
        flex-direction: column;
        align-items: center;
    }

    input[type=email], input[type=password]{
        display:flex;
        width: 16rem;
        height: 2.1rem;
        border-radius: 4px;
        border: 1px solid #808080;
        box-sizing: border-box;
        margin: 1rem 1rem;
        font-family: Poppins;
        font-size:0.7rem;
    }

    input[type=submit]{
        display:inline-block;
        width: 16rem;
        height: 2.1rem;
        text-align:center;
        background:#E6C02F;
        border: none;
        border-radius: 4px;
        border: 1px solid #808080;
        color:#FFFFFF;
        font-family: Poppins;
        font-weight: bold;
    }

    input[type=submit]:hover{
        background: #ed9d24;
    }

    .invalid-feedback{
        background:aqua;
        font-family: Poppins;
        color:red;
        font-size: 0.8rem;
        text-align:center;
    }

    .forget-pass{
        margin-bottom: 0.5rem;
        font-family: Poppins;
        font-size:0.7rem;
        font-style: normal;
        color: #808080;
        text-align: center;
    }

    .forget-pass:hover{
        color: #1a49d9;
    }

</style>