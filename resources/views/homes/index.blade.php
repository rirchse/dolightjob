@extends('home')
@section('title', 'Home')
@section('content')

        <!-- firsthead-->
        <header class="firsthead">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                        <div class="text-center text-white">
                            <!-- Page heading-->
                            <h1 class="mb-5 ">Do Light Job</h1>

                            <!-- Signup form-->

                            <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN">


                                <div class="row">
                                    <div class="col">
                                        <input class="form-control form-control-lg" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                                        <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:required">Email Address is required.</div>
                                        <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:email">Email Address Email is not valid.</div>
                                    </div>


                                    <div class="col-auto"><button class="btn btn-primary btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                                </div>


                                <div class="d-none" id="submitSuccessMessage">
                                    <div class="text-center mb-3">
                                        <div class="fw-bolder">Form submission successful!</div>
                                        <p>To activate this form, sign up at</p>
                                        <a class="text-white" href="https://dolightjob.com/login">https://dolightjob.com/login</a>
                                    </div>
                                </div>


                                <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Icons Grid-->
        <section class="features-icons bg-light text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex"><i class="bi bi-person-plus m-auto text-primary"></i></div>
                            <h3>Join Us</h3>
                            <p class="lead mb-0">Join us to get all SMM Services. There are Available YouTube, Facebook, Instagram, Sign-Up, Apps promotion, and many more tasks</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                            <div class="features-icons-icon d-flex"><i class="bi bi-laptop m-auto text-primary"></i></div>
                            <h3>Easy To Work</h3>
                            <p class="lead mb-0">You can get a lot of easy jobs here and earn easily in a secure marketplace. You can earn a lot more by completing a very simple tasks</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                            <div class="features-icons-icon d-flex"><i class="bi bi-file-earmark-plus m-auto text-primary"></i></div>
                            <h3>Post a Job</h3>
                            <p class="lead mb-0">You can post your job and get your job done easily. If you are a freelancer on Fiverr, Upwork so on, this site can be very helpful for you</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Image Showcases-->
        <section class="showcase text-center">
            <div class="container-fluid p-0">
                <div class="row g-0">

                    <div class="col-lg-7 order-lg-2 text-white showcase-img" style="background-image: url('#')">

                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/0bWv6eNy38g" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                    </div>


                    <div class="col-lg-5 order-lg-1 my-auto showcase-text">
                        <h2>As a Freelancer</h2>
                        <p class="lead mb-0">
                            As a Freelancer, you can get here a lot of social media promotion micro-jobs in dolightjob.com. There are available in the marketplace social networks, writing, testing websites SEO Tasks, Data entry works, Searching Jobs, Installing and testing mobile apps right through to language learning sales and marketing accounting and legal services
                        </p>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-7 text-white showcase-img" style="background-image: url('/homes/img/bg-showcase-2.png')"></div>
                    <div class="col-lg-5 my-auto showcase-text">
                        <h2>As a Buyer</h2>
                        <p class="lead mb-0">
                            As a Buyer, you can post here your promotional tasks in this micro-job site dolightjob.com.  You can complete your jobs by posting your available in the marketplace about social networks, writing, testing websites SEO Tasks, Data entry works, Searching Jobs, Installing and testing mobile apps right through to language learning sales and marketing accounting and legal services
                        </p>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-lg-7 order-lg-2 text-white showcase-img" style="background-image: url('/homes/img/bg-showcase-3.png')"></div>
                    <div class="col-lg-5 order-lg-1 my-auto showcase-text">
                        <h4>Easy to Use</h4>
                        <p class="lead mb-0">
                            Do Light Job is a popular micro job site in the world. You can be got lots of video tutorials on YouTube. It’s easy to get support. You can get 24/7 support by using Live chat, Messenger or Mobile calling. Our support team are always here to provide solution if you have any issues to know
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials-->
        <section class="testimonials text-center bg-light">
            <div class="container">
                <h2 class="mb-5 ">Our Active Team</h2>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                            <img class="img-fluid rounded-circle mb-3" src="/homes/img/Rocky.png" alt="..." />
                            <h5>Rafiqul Islam Rocky</h5>
                            <p class="font-weight-light mb-0">Founder & Owner: Chalan Beel Technology</p>

                            <div class=" social mt-2 shadow p-2 mb-5 rounded">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item me-5">
                                        <a href="https://www.facebook.com/rirchse" target="blank"><i class="bi-facebook social"></i></a>
                                    </li>
                                    <li class="list-inline-item me-5">
                                        <a href="https://www.youtube.com/channel/UCN9JhGoSS_eqW7e07FpH6kw?sub_confirmation=1" target="blank"><i class="bi bi-youtube social"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://www.instagram.com/rirchse/" target="blank"><i class="bi-instagram social"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                            <img class="img-fluid rounded-circle mb-3" src="/homes/img/sayed.png" alt="..."/>
                            <h5>Abu Sayed</h5>
                            <p class="font-weight-light mb-0"> Founder & CEO Of Dolightjob.com</p>

                            <div class=" social mt-2 shadow p-2 mb-5 rounded">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item me-5">
                                        <a href="https://www.facebook.com/dolightjob" target="blank"><i class="bi-facebook social"></i></a>
                                    </li>
                                    <li class="list-inline-item me-5">
                                        <a href="https://www.youtube.com/channel/UCjLtF79sFGA55eZMSwFcbPw?sub_confirmation=1" target="blank"><i class="bi bi-youtube social"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://www.instagram.com/sayed124m/" target="blank"><i class="bi-instagram social"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                            <img class="img-fluid rounded-circle mb-3" src="/homes/img/shihab.png" alt="..." />
                            <h5>Shihab Uddin</h5>
                            <p class="font-weight-light mb-0">Admin & Support Manager</p>

                            <div class=" social mt-2 shadow p-2 mb-5 rounded">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item me-5">
                                        <a href="https://www.facebook.com/profile.php?id=100013348187112" target="blank"><i class="bi-facebook social"></i></a>
                                    </li>
                                    <li class="list-inline-item me-5">
                                        <a href="#" title=" Coming Soon"><i class="bi bi-youtube social"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#"  title=" Coming Soon"><i class="bi-instagram social"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection