<html>
    <body>
        <div class="floating-box">
            <div class="pic-container">
                <img class="prof-pic" src="https://bit.ly/fcc-relaxing-cat" alt="A cute orange cat lying on its back.">
            </div>
            <div class="field-container">
                <p>Lupa password? Silahkan masukkan email Anda untuk  menerima link reset password dari kami. </p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    @if ($errors->has('email')) 
                        <span>
                            <p class="invalid-feedback">Email is not registered.</p>
                        </span>
                    @endif
                    
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <div style="text-align:center;">
                        <input type="submit" value="Send Email">
                    </div>
                </form> 
            </div>
            <div>
                <a class="login" href="{{url('/login')}}">Login</a>
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
        text-align: center;
    }

    .pic-container{
        display: flex;
        height: 35%;
        width: 100%;
        justify-content:center;
    }

    .prof-pic{
        border-radius:50%;
    }

    .field-container{
        margin-top: 1rem;
        display: flex;
        height: 65%;
        width: 100%;
        flex-direction: column;
        align-items: center;
        font-family: Poppins;
        font-size:0.8rem;
        color: #808080;
    }

    input[type=email]{
        display:flex;
        width: 16rem;
        height: 2.1rem;
        border-radius: 4px;
        border: 1px solid #808080;
        box-sizing: border-box;
        margin: 0.75rem 1rem;
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

    .login{
        margin: 1rem 0;
        font-family: Poppins;
        font-size:0.7rem;
        font-style: normal;
        color: #808080;
    }

    .login:hover{
        color: #1a49d9;
    }
    .invalid-feedback{
        font-family: Poppins;
        color:red;
        font-size: 0.8rem;
        text-align:center;
        margin-top: 0;
    }
</style>
