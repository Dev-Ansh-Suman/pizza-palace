<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fav Icon -->
        <link rel="icon" type="image/png" href="{{url('pizaa-favicon.png')}}">

        <title>Pizza Palace</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstarp -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style type="text/css">
            .cart {
                position: relative;
                display: inline-block;
                float: right;
            }
            .cart-content {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 99999;
                width: 300px;
                right: 0%;
            }
            .cart-items{
                height: 300px;
                overflow-y: scroll;
                overflow-x: hidden;
            }
            .cart-total-div {
                background: #fff;
                color: #fd509d;
                padding-top: 15px;
                padding-left: 15px;
                padding-bottom: 15px;
            }
            .cart-heading {
                background: #fff;
                color: #fd509d;
                padding-top: 15px;
                padding-left: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #000;
            }
            .page-heading {
                color: #fd509d;
            }
            .cart-total, .btn-checkout {
                float: right;
                padding-right: 15px !important;
            }
            .cart:hover .cart-content {display: block;}
            .cart-count {
                position: absolute;
                top: -10px;
                right: -10px;
                padding: 2px 4px;
                border-radius: 60%;
                background: #fd509d;
                color: white;
            }
            form.counter {
                width: 300px;
                margin: 0 auto;
                text-align: center;
                padding-top: 50px;
            }

            .value-button {
                display: inline-block;
                border: 1px solid #ddd;
                margin: 0px;
                width: 40px;
                height: 20px;
                text-align: center;
                vertical-align: middle;
                padding: 11px 0;
                background: #eee;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            .value-button:hover {
                cursor: pointer;
            }

            form.counter .decrease {
                margin-right: -4px;
                border-radius: 8px 0 0 8px;
            }

            form.counter .increase {
                margin-left: -4px;
                border-radius: 0 8px 8px 0;
            }

            form.counter .input-wrap {
                margin: 0px;
                padding: 0px;
            }

            input.number {
                text-align: center;
                border: none;
                border-top: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
                margin: 0px;
                width: 40px;
                height: 40px;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>