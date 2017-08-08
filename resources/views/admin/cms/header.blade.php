@extends('layouts.admin_layout')

@section('css')
    <style>
        table tr td{
            text-align:center;
            vertical-align:middle;
        }
    </style>

@endsection

@section('content')

    <h3>Header Content</h3>
    {!! Form::open(['method'=>'Post', 'action'=> ['admin\HeaderController@store'], 'files'=>true]) !!}

    {{csrf_field()}}


    <div class="form-group">

        {!! Form::label('path', 'Add Photo.') !!}<br>
        {!! Form::file('path', null, ['class' => 'form-control']) !!}
        &nbsp;&nbsp; Recommend image size: 629px by 223px

    </div>
    <div class="form-group">
        {!! Form::submit('Add Image', ['class' => 'btn btn-primary']) !!}
    </div>
    {{csrf_field()}}
    {!! Form::close() !!}

    @if(!empty($photos))

       <table class="table table-striped table-bordered table-hover">
           <thead>
           <tr>
               <th>ID</th>
               <th>Image</th>
               <th>visible</th>
           </tr>
           </thead>
           <tbody>

           @foreach($photos as $photo)
               <tr>
                   <td align="center">{{$photo->id}}</td>
                   <td><img height="100" src="/images/{{$photo->path}}" class="noBorder"> </td>


                   <td align="center">
                       {!! Form::model($photo, ['method'=>'Patch', 'action'=> ['admin\HeaderController@update',  $photo->id]]) !!}
                       {{csrf_field()}}
                             <button type="submit" class="btn btn-primary">{{ $photo->visible == 1 ? 'Visible' : 'Not Visible'}}</button>
                       {!! Form::close() !!}
                   </td>

                   <td align="center">
                       {!! Form::open(['method'=>'Delete', 'action'=> ['admin\HeaderController@destroy',  $photo->id]]) !!}
                       {{csrf_field()}}
                       <button type="button" class="btn btn-danger">X</button>
                       {!! Form::close() !!}

                   </td>
               </tr>
          @endforeach

           </tbody>
       </table>
    @endif

@endsection

@section('scripts')
    <script>
        $('.visible').click( function() {
            let id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url    : 'ajax/edit',
                type   : 'post',
                data   : {'id': id, '_token': $('input[name=_token]').val()},
                success: function (response) {
                    //console.log(response);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
//,
    </script>
@endsection