@extends("layouts.auth")
@section("style")
<style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root{
            --myfont: 'Mulish',sans-serif;
            --my-btn-font: 'Montserrat',sans-serif;
            --lg-lightcolor: linear-gradient(to left, rgba(116, 235, 213, 0.6), rgba(159, 172, 230, 0.6));
            --lg-color: linear-gradient(to left, #74ebd5, #9face6);
        }
        
        body{
            background: linear-gradient(to left, #74ebd5, #9face6);
            background-size: 100%;
            background-repeat: no-repeat;
            font-family: var(--myfont);
            display: flex;
            align-items: center;
            justify-content: center;
            max-height: 100vh;
            width: 100vw;
        }
        .container{
            background-color: #fff;
            border-radius: 10px;
            -webkit-border-radius: 10px;
            overflow: hidden;
            width: calc(100vw - 65vw);
            max-width: 100%;
        }
        .header{
            background: var(--lg-color);
            padding: 30px 0;
        }
        .header h2{
            color: #222;
            font-family: var(--my-btn-font);
            font-size: 24px;
            text-transform: uppercase;
            text-align: center;
        }
        .form{
            padding: 40px;
            top:50%;
            left:50%;
            border-radius:10px;
        }
        .form .form-control{
            position:relative;
            margin-bottom: 20px;
        }
        .form .form-control input{
            width:100%;
            padding: 15px;
            font-size:13px;
            color:#000;
            letter-spacing:1px;
            margin-bottom:5px;
            border:none;
            border-bottom:1px solid #fff;
            background:transparent;
            outline:none;
            display:block;
            font-family: var(--myfont);
        }
        .form .form-control label{
            position:absolute;
            top:0;
            left:0;
            letter-spacing:1px;
            padding:10px 0;
            font-size:13px;
            color:#fff;
            transition:0.5s;
            display: inline-block;
            margin-bottom: 5px;
        }
        .form .form-control input:focus ~ label,
        .form .form-control input:valid ~ label{
            top:-11px;
            left:10px;
            color:#03a9f4;
            font-size:12px;
        }
        .form .btn{
            background: var(--lg-color);
            border-radius: 6px;
            border: none;
            outline: none;
            color: #fff;
            display: block;
            font-family: var(--my-btn-font);
            font-size: 16px;
            padding: 15px 0;
            margin-top: 20px;
            width: 100%;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 1s ease;
        }
        .form .btn:hover{
            background: linear-gradient(to right, #74ebd5, #9face6);
            color:#000;
        }
        @media(max-width: 998px){
            .container{
                width: calc(100vw - 35vw);
                max-width: 100%;
            }
        }
    </style>
    @endsection

@section("content")
<div class="container">
<main class="form">
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <center>
            <img class="mb-4" src="\assets\img\logo.png" alt="" width="252" height="70">
        </center>
        <center>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        </center>
        <div class="form-control">
            <label>Email</label>
            <input name="email" type="email" placeholder="name@example.com" autocomplete="off" required>
        </div>
        <div class="form-control">
            <label>Password</label>
            <input name="password" type="password" placeholder="Password" autocomplete="off" required>
        </div>
        <div class="form-check text-start my-3">
            <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
            <input class="form-check-input" type="checkbox" name="remember" value="remember-me" id="flexCheckDefault">
        </div>
        <button class="btn" type="submit">Login</button>
        <center>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017-2024</p>
        </center>
    </form>
</main>
</div>
@endsection