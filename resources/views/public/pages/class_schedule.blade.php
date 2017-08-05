<?php $oldID = null ?>
<?php $in = 'in' ?>
@foreach($hours as $hour)
    <?php $newID = $hour->groupHour->id ?>
    @if($oldID != $newID)
<div class="col-lg-8 col-lg-offset-2">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading{{$hour->groupHour->id}}">
                    <h2 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$hour->groupHour->id}}" aria-expanded="true" aria-controls="collapse{{$hour->groupHour->id}}">
                            <h4 class="font-headings"><span class="blue-title">{{$hour->groupHour->name}}</span></h4>
                        </a>
                    </h2>
                </div>
                <div id="collapse{{$hour->groupHour->id}}" class="panel-collapse collapse {{$in}}" role="tabpanel" aria-labelledby="heading{{$hour->groupHour->id}}">
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Days</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($hours as $time)
                                @if($time->groupHour->id === $hour->groupHour->id)
                            <tr>
                                <td>{{$time->description}}</td>
                                <td>{{$time->time}}</td>

                            </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
    @endif
    <?php $in = '' ?>
    <?php $oldID = $hour->groupHour->id ?>
@endforeach