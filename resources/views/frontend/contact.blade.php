@extends('frontend.layouts.master')

@section('title', 'Contact Us - BookBub')

@section('content')
    <div class="page-title-area bg-4">
        <div class="container">
            <div class="page-title-content">
                <h2>Contact Us</h2>

                <ul>
                    <li>
                        <a href="{{ route('frontend.home') }}">
                            Home
                        </a>
                    </li>

                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Contact Area -->
    <section class="contact-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="contact-form">
                        <h2>Write To Us</h2>

                        <form id="contactForm">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Name*</label>
                                        <input type="text" name="name" id="name" class="form-control" required data-error="Please enter your name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Email*</label>
                                        <input type="email" name="email" id="email" class="form-control" required data-error="Please enter your email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Your Phone No</label>
                                        <input type="text" name="phone_number" id="phone_number" required data-error="Please enter your number" class="form-control">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Your Subject</label>
                                        <input type="text" name="msg_subject" id="msg_subject" class="form-control" required data-error="Please enter your subject">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Your Message</label>
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="4" required data-error="Write your message"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn">
                                        Send message
                                    </button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="contacts-info">
                        <h2>Contact Us</h2>
                        <p>Have questions about our book sharing platform? Want to get in touch with our community team? We'd love to hear from you!</p>

                        <ul class="address">
                            <li class="location">
                                <i class="ri-map-pin-fill icon"></i>
                                <span>Address:</span>
                                7755 Grand Ave, Coconut Grove, Merrick Way, KY 44555
                            </li>
                            <li>
                                <i class="ri-phone-fill icon"></i>
                                <span>Phone:</span>
                                <a href="tel:+1-719-504-1984">+1 719-504-1984</a>
                            </li>
                            <li>
                                <i class="ri-mail-fill icon"></i>
                                <span>Email:</span>
                                <a href="mailto:info@bookbub.com">info@bookbub.com</a>
                            </li>
                            <li class="ps-0">
                                <ul>
                                    <li>
                                        <span>Social:</span>
                                    </li>
                                    <li>
                                        <a href="https://www.facebook.com/" target="_blank">
                                            <i class="ri-facebook-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.twitter.com/" target="_blank">
                                            <i class="ri-twitter-line"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/" target="_blank">
                                            <i class="ri-instagram-line"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/" target="_blank">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.pinterest.com/" target="_blank">
                                            <i class="ri-pinterest-line"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Area -->
@endsection
