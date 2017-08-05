<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}} "/>

    {{--<meta name="_token" content="{{ app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()) }}" />--}}
    <link rel="icon" type="image/png" href="{{asset('favicon.png')}}" sizes="32x32">
    <title>Pugs Boxing</title>

    <link href="https://fonts.googleapis.com/css?family=Chewy|Creepster|Piedra|Trade+Winds" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/public.css')}}">
    <style>
        .active { color: #fff!important;}

    </style>
</head>

<body>
<div id="left-side"></div>
<div id="right-side"></div>
<div class="container">
    <?php $isFirst = TRUE ?>
    <div id="carousel-boxing" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @for($i=1; $i<= count($photos) ;$i++)
                <li data-target="#carousel-boxing" data-slide-to="{{$i}}" class="{{$isFirst ? 'active' : ''}}"></li>
            @endfor

        </ol>

        <div class="carousel-inner" role="listbox">

            @foreach($photos as $photo)
                @if($photo->visible == TRUE)
                    <div class="item {{$isFirst ? 'active' : ''}}">
                        <img height="200" src='/images/{{$photo->path}}' alt="..." class="noBorder">
                    </div>
                @endif
                {{$isFirst = FALSE}}
            @endforeach

        </div>
    </div>

    <h4 class="text-center">Phone Number: {{$phone->phone}}</h4>
</div>
<div class="container">
    <nav class="navbar navbar-inverse " role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Pug's Boxing Gym</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active pages" id="home"><a href="/">Home</a></li>
                    <li><a class="pages" id="membership" href="#">Membership</a></li>
                    <li><a href="#" class="pages" id="class_schedule">Class Schedule</a></li>
                    <li><a href="#" class="pages" id="about">About</a></li>
                    <li><a href="#" class="pages" id="contact">Contact</a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>

    <div class="mainLayout">


</div>

</div>
<div class="container">
    <footer class="footer">
        <div class="container">
            <p class="text-muted text-center">Pug's Boxing Gym | All rights reserved &copy; | {{date('Y')}}</p>
        </div>
    </footer>
</div>

<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/public_side.js')}}"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    window.addEventListener("beforeunload", function () {
        document.body.classList.add("animate-out");
    });

    $( window ).on('load', function(e) {
        e.preventDefault();
        loadHome();

        function loadHome(){
            $.ajax({
                url: 'boxing',
                type: 'GET',
                data: 'id=home',
                success: function(data){
                    $('.mainLayout').html(data).fadeOut(1).delay(20).fadeIn('slow'); //.fadeOut(1).delay(20).fadeIn('slow')
                },
                error: function(data){
                    console.log(data);
                    $('.mainLayout').html('Something went wrong onload.');
                }
            })
        }
    });

    $(document).ready(function () {
        $('.pages').on('click', function(e){
            $('.mainLayout').fadeOut('fast');

            e.preventDefault();
            let page = $(this).attr('id');
            loadPage(page);
            $(this).parents('.nav').find('.active').removeClass('active').end().end().addClass('active');

            function loadPage(page){
                $.ajax({
                    url: 'boxing',
                    type: 'GET',
                    data: 'id=' + page,
                    success: function(data){

                        $('.mainLayout').html(data).fadeIn('slow'); //.fadeOut(1).delay(20).fadeIn('slow')
                    },
                    error: function(data){
                        console.log(data);
                        $('.mainLayout').html('Something went wrong.');
                    }
                })
            }
        });



    });

    /*$('.carousel').carousel({
     interval: 5000
     })*/
</script>



</body>
</html>