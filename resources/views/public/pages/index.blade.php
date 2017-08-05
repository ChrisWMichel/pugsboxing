

<div class="col-lg-4 top-margin">
    <ul class="left-list">
        @foreach($left_list as $list)
            <li>{{$list}}</li>
        @endforeach
    </ul>
</div>
<div class="col-lg-8">
    <h1 class="page-header text-center home-title">{{$home->home_title}}</h1>

    <div class="right-content home-padding">{!! $home->right_content !!}</div>

</div>