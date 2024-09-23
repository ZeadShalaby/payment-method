<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Paymob Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f7f9fc;
        }

        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #6772e5;
            border-color: #6772e5;
        }

        .btn-primary:hover {
            background-color: #5469d4;
            border-color: #5469d4;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h3>Payment Details</h3>

        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif

        <form role="form" action="{{ route('payment.paymob') }}" method="post" class="require-validation"
            id="payment-form">
            @csrf
            <div class='form-row'>
                <div class='col-md-12 form-group required'>
                    <label class='control-label'>Name on Card</label>
                    <input class='form-control' size='4' type='text' required>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-md-12 form-group required'>
                    <label class='control-label'>Card Number</label>
                    <input autocomplete='off' class='form-control card-number' size='20' type='text' required>
                </div>
            </div>
            <div class='form-row'>
                <div class='col-md-4 form-group cvc required'>
                    <label class='control-label'>CVC</label>
                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4'
                        type='text' required>
                </div>
                <div class='col-md-4 form-group expiration required'>
                    <label class='control-label'>Expiration Month</label>
                    <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'
                        required>
                </div>
                <div class='col-md-4 form-group expiration required'>
                    <label class='control-label'>Expiration Year</label>
                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'
                        required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                </div>
            </div>
            <div class="error hide">
                <div class="alert alert-danger"></div>
            </div>
        </form>
    </div>

    <script>
        $(function() {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function(e) {
                var $inputs = $form.find('.required').find('input'),
                    valid = true;
                $('.error').addClass('hide');
                $inputs.each(function(i, el) {
                    if ($(el).val() === '') {
                        $(el).parent().addClass('has-error');
                        $('.error').removeClass('hide').find('.alert').text(
                            'Please fill in all fields.');
                        valid = false;
                    }
                });
                if (!valid) {
                    e.preventDefault();
                } else {
                    e.preventDefault(); // Prevent form submission to handle API call
                    initiatePayment();
                }
            });

            function initiatePayment() {
                var cardData = {
                    card_number: $('.card-number').val(),
                    card_cvc: $('.card-cvc').val(),
                    card_exp_month: $('.card-expiry-month').val(),
                    card_exp_year: $('.card-expiry-year').val()
                };

                fetch('/api/payment/paymob', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(cardData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            // Handle success, e.g. redirect or show success message
                            $form.get(0).submit(); // Submit the form if necessary
                        } else {
                            $('.error').removeClass('hide').find('.alert').text(
                                'Payment initiation failed. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        $('.error').removeClass('hide').find('.alert').text(
                            'There was an error processing your request.');
                    });
            }
        });
    </script>
</body>

</html>
