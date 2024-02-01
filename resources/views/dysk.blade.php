<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dysk.css') }}" >
@php
    if(!isset($typ))
        $typ="dysk"
@endphp
<script>
    $(document).ready(function() {
        $('#sorting').change(function() {
            var sort = $(this).val();
            $.ajax({
                url: '{{ route($typ) }}',
                type: 'GET',
                data: { sort: sort},
                success: function(response) {
                    $('#kontener').replaceWith(response);
                },
                error: function(error) {
                    console.error('Wystąpił błąd AJAX.');
                }
            });
        });
    });
</script>
<!------ Include the above in your HEAD tag ---------->

<div class="container-fluid login-container" id="kontener">
    <div class="collapse" id="navbarToggleExternalContent" style="">
        <div class="login-form-2">
            <h4>Witaj {{session()->get('login')}}</h4>
            <div class="head">
                Wybierz kategorię:
            </div>
            <a href="/dysk/ostrzegawcze">
                <div class="option">
                    Znaki ostrzegawcze
                </div>
            </a>
            <a href="/dysk/zakazu">
                <div class="option">
                    Znaki zakazu
                </div>
            </a>
            <a href="/dysk/nakazu">
                <div class="option">
                    Znaki nakazu
                </div>
            </a>
            <a href="/dysk/informujace">
                <div class="option">
                    Znaki informujące
                </div>
            </a>
            <a href="/dysk/inne">
                <div class="option">
                    Inne znaki
                </div>
            </a>
            <a href="/dysk/dodaj">
                <div class="option">
                    Dodaj zdjęcia
                </div>
            </a>
            <form action="/logout" method="post">
                @csrf
                <input type="submit" class="btn" value="Wyloguj"/>
            </form>
        </div>
    </div>
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="row">
        <div class="col-xl-2 login-form-2">
            <h4>Witaj {{session()->get('login')}}</h4>
            <div class="head">
                Wybierz kategorię:
            </div>
            <a href="/dysk/ostrzegawcze">
                <div class="option">
                    Znaki ostrzegawcze
                </div>
            </a>
            <a href="/dysk/zakazu">
                <div class="option">
                    Znaki zakazu
                </div>
            </a>
            <a href="/dysk/nakazu">
                <div class="option">
                    Znaki nakazu
                </div>
            </a>
            <a href="/dysk/informujace">
                <div class="option">
                    Znaki informujące
                </div>
            </a>
            <a href="/dysk/inne">
                <div class="option">
                    Inne znaki
                </div>
            </a>
            <a href="/dysk/dodaj">
                <div class="option">
                    Dodaj zdjęcia
                </div>
            </a>
            <form action="/logout" method="post">
                @csrf
                <input type="submit" class="btn" value="Wyloguj"/>
            </form>
        </div>
        <div class="col-xl-10 login-form-1">
            <h2>Baza danych uczących - znaki drogowe</h2>
            <h4>Dominik Szydlik</h4>
            <hr>
            @if(!empty($typ)&&$typ!='dysk')
            <div class="signs">
                <div class="sorting">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="{{route('downloadAll', ['path'=>$typ])}}">
                                <button class="btn-blue">Pobierz wszystkie</button>
                            </a>
                        </div>
                        <div class="col-sm-8">
                            <h4>Znaki {{$typ}}</h4>
                        </div>
                        <div class="col-sm-2">
                            <h6>Wybierz sposób sortowania</h6>
                            <select class="select-blue" id="sorting">
                                <option value="1" @if(isset($sort)&&$sort==1) selected @endif>Od najnowszych</option>
                                <option value="2" @if(isset($sort)&&$sort==2) selected @endif>Od najstarszych</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="bloczki">
                    <div class="row">
                        <!-- pętla obrazków -->
                        @php
                            if(isset($sort)){
                                if($sort==2)
                                    $znaki=$znaki->reverse();
                            }
                        @endphp
                        @foreach($znaki as $znak)
                            <div class="col-md-3 gallery">
                                <img src="{{asset($znak->file)}}" alt="">
                                <hr>
                                <h6>Dodany przez: {{$znak->login}}</h6>
                                <h6>{{$znak->data}}</h6>
                                <h6 class="link"><a href="{{route('download', ['filename'=>$znak->file])}}">Pobierz</a></h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @elseif(!empty($dodaj))
                <h3>Formularz dodawania</h3>
                <div class="container" style="height: 50px; margin-top: 1%;">
                    @if(!empty($fl=session()->get('fl')))
                        @if($fl==1)
                            <div class="alert alert-success" role="alert">
                                Zdjęcia zostały dodane na serwer!
                            </div>
                        @endif
                    @endif
                </div>
                <form action="/upload" method="POST" enctype="multipart/form-data">
                    <h5>Wybierz pliki oraz ich kategorię:</h5>
                    @csrf
                    Wybierz pliki:
                    <input type="file" name="files[]" multiple class="select-white" accept="image/*"><br>
                    Wybierz kategorię:
                    <select name="typ" class="select-white">
                        <option value="1">Znaki ostrzegawcze</option>
                        <option value="2">Znaki zakazu</option>
                        <option value="3">Znaki nakazu</option>
                        <option value="4">Znaki informujące</option>
                        <option value="5">Inne znaki </option>
                    </select><br>
                    <input type="submit" class="select-blue p-3" value=" Dodaj ">
                    <img src="" alt="">
                </form>
            @else
                <h2 id="desktop"><< Wybierz kategorię z menu po lewej <<</h2>
                <h2 id="mobile">/\ Wybierz kategorię z rozwijanego menu na górze /\</h2>
            @endif
        </div>
    </div>
</div>
<script>
    function resize() {
        var desktop = document.getElementById('desktop');
        var mobile = document.getElementById('mobile');

        if (window.innerWidth < 1140) {
            desktop.style.display = 'none';
            mobile.style.display = 'block';
        } else {
            desktop.style.display = 'block';
            mobile.style.display = 'none';
        }
    }
    window.addEventListener('resize', resize);
    resize();
</script>
