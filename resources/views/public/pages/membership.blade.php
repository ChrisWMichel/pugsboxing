


<?php $oldID = NULL?>
<?php $in = 'in'?>

{{--<div class="row col-lg-12 membership-page">--}}

@if(!empty($sale))
    <div class="col-lg-8 col-lg-offset-2">
        {!! $sale->body !!}
    </div>
@endif
<table>
    <tr>
        <td style="width: 40%;">
            {{--<div class="col-lg-4">--}}
                <div class="panel-group packages" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($memberships as $membership)
                        <?php $newID = $membership->category->id ?>
                        <div class="panel panel-default">
                            @if($newID != $oldID)
                                <div class="panel-heading" role="tab" id="heading{{$membership->category->id}}">
                                    <h4 class="panel-title">
                                        <a role="button" class="active-menu" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$membership->category->id}}" aria-expanded="true" aria-controls="collapse{{$membership->category->id}}">
                                            <h4 class="font-headings"><span class="blue-title">{{$membership->category->name}}</span> - {{$membership->category->description}}</h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse{{$membership->category->id}}" class="panel-collapse collapse {{$in}}" role="tabpanel" aria-labelledby="heading{{$membership->category->id}}">
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Package</th>
                                                <th>Price</th>
                                            </tr>
                                            </thead>
                                            @foreach($memberships as $list)
                                                @if($list->category->id === $membership->category->id)

                                                    <tbody>
                                                    <tr>
                                                        <td>{{$list->package}}</td>
                                                        <td>${{$list->price}}</td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                    </tbody>
                                        </table>
                                        <?php $oldID =  $membership->category->id?>
                                    </div>
                                </div>
                        </div>
                        @endif
                        <?php $in = '' ?>
                    @endforeach
                </div>
           {{-- </div>--}}
        </td>
        <td style="width: 70%; padding-left:20px;">
            {{--<div class="col-lg-7 col-lg-offset-5 top-margin ">--}}
    <div class="panel-group  member-desc" id="accordionDesc" role="tablist" aria-multiselectable="false">
        <?php $in = 'in'?>
            @foreach($descriptions as $description)

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{{$description->id + 50}}">
                            <h4 class="panel-title">
                                <a role="button" class="active-menu" data-toggle="collapse" data-parent='#accordionDesc' href="#collapse{{$description->id + 50}}" aria-expanded="true" aria-controls="collapse{{$description->id + 50}}">
                                    <h4 class="font-headings blue-title">{{$description->title}}</h4>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{$description->id + 50}}" class="panel-collapse collapse {{$in}}" role="tabpanel" aria-labelledby="heading{{$description->id + 50}}">
                            <div class="panel-body right-content">
                                {!! $description->body !!}<br>

                            </div>
                        </div>
                    </div>


            <?php $in = ''?>
        @endforeach
            </div>
       {{-- </div>--}}
        </td>
    </tr>
</table>




{{--</div>--}}

