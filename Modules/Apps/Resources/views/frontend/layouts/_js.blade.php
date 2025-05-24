{{-- ADD / UPDATE  ITEMS TO SHOPPING CART--}}
{{-- <script>
    $(document).ready(function() {

        $('.form').on('submit',function(e) {
            e.preventDefault();

            var url     = $(this).attr('action');
            var method  = $(this).attr('method');

            $.ajax({

                url: url,
                type: method,
                dataType: 'JSON',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function(){
                  $(".inner-page").addClass('disabled');
                  $('#loading').removeClass('hidden');
                },
                success:function(data){
                  displaySuccess(data['message']);
                  $('.add_to_cart').prop('disabled',false);
                  shoppingCart();
                },
                error: function(data){
                  console.log(data);
                  displayErrors(data);
                  $('.add_to_cart').prop('disabled',false);
                  shoppingCart();
                },
                complete:function(data){
                  $(".inner-page").removeClass('disabled');
                  $('#loading').addClass('hidden');
                },
            });

        });

    });


    function displayErrors(data)
    {
        console.log($.parseJSON(data.responseText));

        var getJSON = $.parseJSON(data.responseText);

        var output = '<ul>';

        for (var error in getJSON.errors){
            output += "<li>" + getJSON.errors[error] + "</li>";
        }

        output += '</ul>';

        var wrapper = document.createElement('div');
        wrapper.innerHTML = output;

        swal({
          content: wrapper,
          icon: "error",
          dangerMode: true,
        })
    }


    function displaySuccess(data)
    {
        swal({
          closeOnClickOutside: false,
          closeOnEsc: false,
          text: data,
          icon: "success",
          buttons: {
            success: {
              text: "{{ __('catalog::frontend.cart.btn.got_to_shopping_cart') }}",
              value: 'redirect',
              className: 'btn btn-primary',
            },
            close: {
              className: 'btn btn-danger',
              text: "{{ __('catalog::frontend.cart.btn.continue') }}",
              value: 'close',
              closeModal: true
            },
          }
        })
        .then((value) => {
          switch (value) {
            case "redirect":
              window.location.replace("#");
              break;
          }
        });
    }

</script>


<script>
	function shoppingCart()
	{
		$.ajax({
	        url: '#',
	        type: "GET",
	        success:function(res){
		        $(".shopping_cart").html(res);
	        },
	        error:function(res){
	        }
	    });
	}
</script> --}}
