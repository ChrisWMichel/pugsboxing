@extends('layouts.admin_layout')




<?php $oldID = null ?>
<?php $in = 'in' ?>
@section('content')
    @include('includes.tinyeditor')
<h2 class="page-header">Packages</h2>

<h4>Temporary Sale</h4>
    <h5 class="sale-msg blue-title"></h5>
    <?php $isChecked = $check_sales->temp_sales_page == 1 ? 'checked="checked"' : null; ?>
<input type="checkbox" class="check-sale" {{$isChecked}} name="addSale"> Add to public page
    <br>
{!! Form::model($sale, ['method'=>'patch', 'action'=> ['admin\SalesController@update',  $sale->id]]) !!}
{{csrf_field()}}

<div class="form-group">
    {!! Form::textarea('body', $sale->body, ['class' => 'form-control', 'rows' => 10]) !!}
</div>

<div class="form-group">
    {!! Form::submit('Save Changes', ['class' => 'btn btn-primary pull-right descSaveBtn']) !!}
</div><br>

{!! Form::close() !!}
<br><br>
<div class="panel-group packages" id="accordion" role="tablist" aria-multiselectable="false">
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
                            <tbody>
                            @foreach($memberships as $list)
                                @if($list->category->id === $membership->category->id)
                                    <tr>
                                    <form method="post" action="#" id="{{$list->id}}" class="package-form">
                                        {{csrf_field()}}


                                        <td><input type="text" name="package" id="package" value="{{$list->package}}" class="form-control"></td>
                                        <td><input type="text" name="price" id="price" value="{{$list->price}}" class="form-control price"></td>
                                        @if($list->pack_num != null)
                                            <td class="shorten-length"><input type="text" name="pack_num" id="pack_num" value="{{$list->pack_num}}" class="form-control"></td>
                                        @endif
                                        <td><input type="submit" value="Save Changes" class="btn btn-primary"></td>


                                    </form>

                                    </tr>

                                    @endif
                                    @endforeach
                            <form method="post" action="#" >
                                {{csrf_field()}}
                               {{-- <input type="hidden" name="catID" id="catID" value="{{$list->category->id}}">--}}

                                <td><input type="text"  name="pac_name" class="form-control pac_name" id="{{'pac_name' . $newID}}" placeholder="name"></td>

                                <td><input type="text" name="pac_price" class="form-control pac_price" id="{{'pac_price' . $newID}}" placeholder="Description"></td>

                                <td><input type="button" id="{{$newID}}" value="Add Package" class="btn btn-success package-add"></td>

                            </form>
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

<div class="alert">
    @include('flash::message')
</div>

@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('.package-form').on('submit', function (e) {
                e.preventDefault();
                const id = this.id;
                const packageName = $(this.package).val();
                const price = $(this.price).val();
                const pack_num = $(this.pack_num).val();

                data = {
                    'id': id,
                    'package' : packageName,
                    'price' : price,
                    'pack_num' : pack_num
                };

                const url = '/packageupdate';

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

            /*Prevent user from using '$' sign*/
            $(function () {
                $(document).on('keyup keydown keypress', function (event) {
                    if (event.charCode === 36) {
                        return false;
                    }
                });
            });

            $('.package-delete').click(function(){

                const id = $(this).attr('id');
                const url = '/packagedelete';

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

            $('.package-add').on('click', function(){
                let catID = this.id;
                let name = $('#pac_name' + catID).val();
                let price = $('#pac_price' + catID).val();

                let data = {
                    'package' : name,
                    'price' : price,
                    'catID' : catID
                };
                //console.log('ID: ' + catID + ' package: ' + name + ' price: ' + price);

                name = '';
                price = '';
                const url = "{{route('packages.store')}}";
                $.ajax({
                    url    : url,
                    type   : 'post',
                    data   : data,
                    success: function (data) {
                        //console.log('This is working');
                        //location.reload();
                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                    }
                })

            });

            $('.check-sale').change(function () {
                // The change is being done in the main_layout table. Toggeling temp_sales_page.
                const id = 1;

                const url = "sale/" + id;  {{--{{route('sale.update')}}--}}
                $.ajax({
                    url    : url,
                    type   : 'get',
                  //  data   : {'id' : id},
                    success: function (data) {
                        $('.sale-msg').html('updated');
                        setTimeout(function () {
                            $('.sale-msg').hide();
                        }, 5000);


                    },
                    error  : function (data) {
                        console.log('Something went wrong.');
                    }
                })
            })
        });
    </script>

@endsection