
<div class="col-lg-4">
    <div class="well contact-center right-content">
        <h2 class="home-title">Come visit us</h2>
        <h3>{{$info->title}}</h3>
        <h4>{{$info->street}}</h4>
        <h4>{{$info->city}}, {{$info->state}}</h4>
        <h4>{{$info->zipcode}}</h4>
        <br><br>
        <h2 class="home-title">...or call!</h2>
        <h3>{{$info->phone}}</h3>
    </div>
</div>


<div class="col-lg-8">
        <div id="contact-page">

                <div class="form-group">
                    <div class="error text-center alert alert-danger hidden">
                        <ul></ul>
                    </div>
                </div>

        <div class="panel panel-info right-content">
            <div class="panel-heading">Contact Us!</div>
            <div class="panel-body">
                <form method="post" action="#" id="contact-form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="firstname">Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Send" class="btn btn-lg btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="processing text-center">
        <img src="{{asset('sending_email.gif')}}" width="274px" height="274px" style="border: none; box-shadow: none">
    </div>
</div>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.processing').hide();

    $('#contact-form').on('submit', function(e){
        e.preventDefault();

        data = {
            'firstname' : $('#firstname').val(),
            'email'     : $('#email').val(),
            'subject'   : $('#subject').val(),
            'message'   : $('#message').val()
        };

        $('#contact-page').hide();
        $('.processing').show();

        const url = '/contact';

        $.ajax({
            url    : url,
            type   : 'post',
            data   : data,
            dataType: "json",
            success: function (data) {
                $('.processing').hide();
                $('#contact-page').html("<h3 style='color: blue; margin-top: 50px;'> Thanks for contacting us " + data.firstname + ". Your message has been sent.</h3>").fadeOut(1).delay(20).fadeIn('slow');
            },
            error  : function (data) {
                //let response = jQuery.parseJSON(data.responseText);
                let response = JSON.parse(data.responseText);
                printErrorMsg(response);
                data.responseText = [];
            }
        });

        function printErrorMsg (msg) {
            $(".error").find("ul").html('');
            $('.error').removeClass('hidden');
            $.each( msg, function( key, value ) {
                $(".error").find("ul").append('<li>'+value+'</li>');
            });
        }
    })

</script>