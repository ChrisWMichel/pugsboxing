@extends('layouts.admin_layout')

@section('css')
    <style>

    </style>

@endsection

@section('content')

    <h2 class="page-header">Categories</h2>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <form method="post" action="#" id="{{$category->id}}" class="category-form">
                    <input type="hidden" name="cat_id" id="cat_id" value="{{$category->id}}" class="cat_id">
                    {{csrf_field()}}

                    <td><input type="text"  name="name" value="{{$category->name}}" class="form-control name"></td>

                    <td><input type="text" name="description" value="{{$category->description}}" class="form-control description"></td>

                    <td><input type="submit" value="Save Changes" class="update-cat btn btn-primary"></td>

                </form>
                <td><a href="#" id="{{$category->id}}" class="category-delete btn btn-sm btn-danger">X</a> </td>
            </tr>
            @endforeach


        <form method="post" action="#" >
            {{csrf_field()}}

            <td><input type="text"  name="cat_name" class="form-control" id="cat_name" placeholder="name"></td>

            <td><input type="text" name="cat_description" class="form-control" id="cat_description" placeholder="Description"></td>

            <td><input type="button" value="Add Category" class="btn btn-success category-add"></td>

        </form>

        </tbody>
    </table>

        @include('flash::message')
  
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
           $('.category-form').on('submit', function (e) {
                e.preventDefault();
                const id = this.id;
                 const name = $(this.name).val();
                 const description = $(this.description).val();

                     data = {
                         'id': id,
                         'name' : name,
                         'description' : description
                     };

                     const url = '/categoryupdate';

                    $.ajax({
                        url    : url,
                        type   : 'post',
                        data   : data,
                        success: function (data) {
                            location.reload();
                        },
                        error  : function (data) {
                            console.log('Something went wrong.');
                            console.log(data);
                        }
                    })
        });

            $('.category-delete').click(function(){

                const id = $(this).attr('id');
                const url = '/categorydelete';

                $.ajax({
                    url    : url,
                    type   : 'get',
                    data   : {'id':id},
                    success: function (data) {
                        //console.log(data);
                        location.reload();
                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                        console.log('failed: ' + data.id);
                    }
                })
            });

            $('.category-add').on('click', function(){
                let name = $('#cat_name').val();
                let description = $('#cat_description').val();

                let data = {
                    'name' : name,
                    'description' : description
                };

                const url = "{{route('categories.store')}}";

                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        location.reload();
                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                    }
                })

            });


    });
    </script>

@endsection