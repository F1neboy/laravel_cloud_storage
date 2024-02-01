<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/login.css') }}" >
<!------ Include the above in your HEAD tag ---------->

<div class="container" style="height: 50px; margin-top: 1%;">
    @if(!empty($al=session()->get('al')))
        @if($al==1)
            <div class="alert alert-success" role="alert">
                Konto zostało utworzone! Możesz sie zalogować!
            </div>
        @endif
        @if($al==2)
            <div class="alert alert-danger" role="alert">
                Nie poprawny login i/lub hasło!
            </div>
        @endif
        @if($al==3)
            <div class="alert alert-danger" role="alert">
                Ten użytkownik już istnieje!
            </div>
        @endif
    @endif

</div>
<div class="container login-container">
    <div class="row row-main">
        <div class="col-md-12">
            <h2>Baza danych uczących - znaki drogowe</h2>
            <h4>Dominik Szydlik</h4>
        </div>
        <div class="col-lg-6 login-form-2">
            <h3>Logowanie</h3>
            <form method="POST" action="/zaloguj">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="login" placeholder="Podaj nick" value="" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Podaj hasło" value="" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Zaloguj" />
                </div>
            </form>
        </div>
        <div class="col-lg-6 login-form-1">
            <h3>Rejestracja</h3>
            <form method="post" action="/rejestruj">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="login" placeholder="Podaj login" value="" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Podaj hasło" value="" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Zarejestruj" />
                </div>
            </form>
        </div>
    </div>
</div>
