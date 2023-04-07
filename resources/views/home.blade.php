<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>dolightjob</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="/homes/img/favicon.png" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/homes/css/styles.css?v=1.0.1" rel="stylesheet"/>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top fixed-top shadow">
            <div class="container">
                <div class="float-left">
                    <a class="navbar-brand" href="#"><img src="/homes/img/Banner.png"></a>
                </div>
                <div class="float-right">
                    <a class="btn btn-primary float-1" href="/signup">Sign Up</a>
                    <a class="btn btn-primary " href="/login">Login</a>
                </div>
            </div>
        </nav>

@yield('content')


        <!-- Call to Action-->
        <section class="call-to-action text-white text-center" id="signup">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <h2 class="mb-4">Sign up now!</h2>

                        <!-- Signup form-->
                        <form class="form-subscribe" id="contactFormFooter" data-sb-form-api-token="API_TOKEN">

                            <!-- Email address input-->
                            <div class="row">
                                <div class="col">
                                    <input class="form-control form-control-lg" id="emailAddressBelow" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddressBelow:required">Email Address is required.</div>
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddressBelow:email">Email Address Email is not valid.</div>
                                </div>
                                <div class="col-auto"><button class="btn btn-primary btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                            </div>

                            <!-- Submit success message-->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    <p>To activate this form, sign up at</p>
                                    <a class="text-white" href="#">Sign Up Page Pop Up Here</a>
                                </div>
                            </div>

                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer-->
        <footer class="footer bg-light">
            <div class="container padding-0">
                <div class="row">
                    <div class="col-lg-7 h-100 text-center text-lg-start my-auto">
                        <ul class="list-inline mb-2 ">
                            <li class="list-inline-item"><a class="a" href="/about">About</a></li>
                            <li class="list-inline-item"><a class="a" href="/contact">Contact</a></li>
                            <li class="list-inline-item"><a class="a" href="#">Terms of Service</a></li>
                            <li class="list-inline-item"><a class="a" href="#">Privacy Policy</a></li>
                        </ul>
                        <p class="text-muted small mb-4 mb-lg-0 ">&copy;2021 dolightjob  All Rights Reserved.</p>
                    </div>
                    <div class="col-lg-5 h-100 text-center text-lg-end my-auto">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item me-4">
                                <a href="https://www.youtube.com/channel/UC54uPc0r5wR9VHn5fTBLw9w?sub_confirmation=1" target="blank"><i class="bi bi-youtube fs-3"></i></a>
                            </li>

                            <li class="list-inline-item me-4">
                                <a href="https://www.facebook.com/dolightjob" target="blank"><i class="bi-facebook fs-3"></i></a>
                            </li>

                            <li class="list-inline-item me-4">
                                <a href="#" target="blank"><i class="bi-twitter fs-3"></i></a>
                            </li>

                            <li class="list-inline-item">
                                <a href="#" target="blank"><i class="bi-instagram fs-3"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>