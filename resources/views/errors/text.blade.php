<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Coming Soon - Templates</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Poppins', sans-serif;
            color: #495057;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #app {
            flex: 1;
        }

        .section {
            display: flex;
            align-items: center;
            min-height: 90vh;
        }

        .page-error {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 3rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            text-align: center;
        }

        .page-error:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .page-inner {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .rocket-icon {
            font-size: 4rem;
            color: #007bff;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .page-inner h4 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .page-description {
            font-size: 1.1rem;
            color: #6c757d;
            line-height: 1.8;
            background-color: #f8f9fa;
            padding: 0.5rem;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            margin: 2rem 0;
            position: relative;
            text-align: center;
        }

        .page-description::before {
            content: """;
            font-size: 4rem;
            color: rgba(0, 123, 255, 0.1);
            position: absolute;
            top: -10px;
            left: 10px;
        }

        .page-search {
            margin-top: 2rem;
            text-align: center;
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto 2rem auto;
            text-align: center;
        }

        .form-control {
            border-radius: 30px;
            padding: 0.75rem 1.5rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s;
            text-align: center;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group-text {
            border-radius: 30px 0 0 30px;
            background: white;
            border-right: none;
        }

        .btn-primary {
            border-radius: 30px;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            transition: all 0.3s;
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(13, 110, 253, 0.4);
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
        }

        .btn-action {
            min-width: 200px;
            margin: 0.5rem;
        }

        .btn-primary i {
            margin-right: 0.5rem;
        }

        .simple-footer {
            text-align: center;
            padding: 1.5rem 0;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            .page-error {
                padding: 2rem 1rem;
                margin: 1rem;
            }

            .page-inner h4 {
                font-size: 1.8rem;
            }

            .btn-action {
                width: 100%;
                margin: 0.5rem 0;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container">
                <div class="page-error">
                    <div class="page-inner">
                        <div class="rocket-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4>Good News! Templates Are Coming Soon</h4>
                        <div class="page-description">
                            Dear {{ $profile->first_name ?? 'Empty' }} {{ $profile->last_name ?? 'Value' }}, we have already received your information. However, the template has not yet been
                            created or designed, as our development activities are still ongoing. Once development is
                            complete, you will receive it absolutely free.
                            <br><br>
                            Meanwhile, if you want, you can use all the existing templates we currently have. We hope
                            you enjoy them. Thank you for your patience and understanding.
                        </div>

                        <div class="page-search">
                            <div class="search-container">
                                <form>
                                    <div class="form-group floating-addon floating-addon-not-append mb-4">
                                        <!-- Empty form group -->
                                    </div>
                                </form>
                            </div>

                            <div class="d-flex justify-content-center flex-wrap action-buttons">
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-action">
                                    <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                                </a>
                                <a href="javascript:history.back()" class="btn btn-primary btn-action">
                                    <i class="fas fa-arrow-left"></i> Go Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="simple-footer">
        © 2023 ProfileCrafting.com
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
</body>

</html>
