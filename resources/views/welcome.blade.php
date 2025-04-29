@extends('layouts.auth')

@section('style')
<style>
    /* Global styles for uniform font, size, weight, and spacing */
    .navbar, .marquee-container marquee, .navbar-nav .nav-link {
        font-family: Arial, sans-serif; /* Unified font */
        font-size: 16px; /* Unified font size */
        font-weight: normal; /* Explicitly setting font-weight to normal */
        letter-spacing: 0.5px; /* Unified letter spacing */
        padding: 8px 0; /* Consistent padding */
        color: #fff;
    }
    .navbar {
        display: flex;
        align-items: center;
        padding: 0.25rem 1rem;
        background-color: #00b2ee;
        justify-content: space-between; /* Distribute items evenly */
        position: fixed; /* Keep navbar at the top */
        top: 0;
        left: 0;
        width: 100%; /* Full width */
        z-index: 1000; /* Make sure it stays above other elements */
    }
    .navbar .nav-link, .navbar .navbar-brand {
        color: #fff !important; /* White text */
    }
    /* Navbar Brand */
    .navbar-brand {
        font-size: 1.5rem;
        color: white !important;
        font-weight: bold;
    }
    .marquee-container {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .marquee-container marquee {
        white-space: nowrap;
        color: #fff;
        font-weight: normal; /* Ensure normal weight for marquee text */
    }
    .navbar-nav .nav-link {
        line-height: 1.5;
    }
    .hero-section {
        background-image: url('assets/img/banner.jpeg'); /* Replace with the actual image URL */
        background-size: cover;
        background-position: center center; /* Centers the image */
        background-repeat: no-repeat; /* Prevents image repetition */
        display: flex;
        align-items: center;
        justify-content: center;
        padding:2.8rem 0;
        width: 100%; /* Ensures full width */
        height: 96.5vh; /* Ensures full viewport height */
        overflow: hidden; /* Prevents overflow */
        margin: 0; /* Remove any margin */
    }
    .hero-content{
        display: flex;
        align-items: flex-start;
    }
    /* Minimal change to make text white */
    .hero-section h1, .hero-section p, .hero-section a.btn {
        color: white;
    }
    /* Inquiry form styles */
    .card {
        background-color: rgba(255, 255, 255, 0.8); /* Translucent white */
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 35px; /* Adds space above the heading */
    }
    .card-body {
        padding: 2rem;
    }
    h1.display-3 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-top: 26px; /* Adds space above the heading */
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    /* Our Courses section overrides */
    section {
        background-color: #f4f4f4; /* Neutral background for "Our Courses" */
        width: 100%; /* Ensures the section takes full viewport width */
        height: 92vh; 
        padding: 0; /* Removes any padding */
        margin: 0; /* Removes any margin */
    }
    .card-body{
        padding: 40px;
        top:50%;
        left:50%;
        border-radius:10px;
    }
    .card-body .md-form{
        position:relative;
        margin-bottom: 20px;
    }
    .card-body .md-form input{
        width:100%;
        padding: 15px;
        font-size:13px;
        color:#000;
        letter-spacing:1px;
        margin-bottom:5px;
        border:none;
        border-bottom:1px solid #007bff;
        background:transparent;
        outline:none;
        display:block;
    }
    .card-body .md-form label{
        position:absolute;
        top:0;
        left:0;
        letter-spacing:1px;
        padding:10px 0;
        font-size:13px;
        color:transparent;
        transition:0.5s;
        display: inline-block;
        margin-bottom: 5px;
    }
    .card-body .md-form input:focus ~ label,
    .card-body .md-form input:valid ~ label{
        top:-11px;
        left:14px;
        color:#007bff;
        font-size:12px;
    }
    /* Gallery */
    .gallery{
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Create 4 columns */
        grid-gap: 20px; /* Add spacing between images */
    }
    .gallery-img{
        height: auto;
        width:100%;
        object-fit:cover;
    }
    /* Placement */
    .placement{
        background-size:cover;
        height:550;
    }
    .placement-sect{
        padding: 50px;
    }
    .placement-sect h2{
        color:#000;
        font-size:40px;
        letter-spacing:1px;
    }
    .placement-sect p{
        color:#000;
        font-size:20px;
        margin-top: 10px;
    }
    .placement-company{
        display:flex;
        flex-wrap:wrap;
    }
    .placement-company img{
        width:20%;
        height:70px;
        margin: 10px;
    }
    /* Testimonial */
    .testimonial{
        width:100%;
        float:left;
        padding-right: 20px;
    }
    .testimonial-content{
        background:#00b2ee;
        color:#fff;
        width:100%;
        float:left;
        padding: 20px;
        font-size:16px;
        line-height:35px;
        position:relative;
    }
    .testimonial-content::after{
        content:"";
        position:absolute;
        top:100%;
        left:20px;
        margin-left:6px;
        border-width:34px;
        border-style:solid;
        border-color:transparent;
        width:0%
    }
    .testimonial-detail{
        width: 100%;
        float: left;
        margin-top: 40px;
    }
    .testimonial-img{
        width: 90px;
        float: left;
        text-align:center;
    }
    .testimonial-img img{
        width: 70px;
        height: 70px;
        border-radius:50%;
    }
     .testimonial-name{
        margin-left: 10px;
        float: left;
        width: calc(100%-100px);
        font-size:16px;
    }
    .testimonial-name h5{
        font-size:18px;
        margin-top: 10px;
    }
    .testimonial-name p{
        font-size:16px;
    }
    .marquee {
        width: 40% !important; /* Reduces the width of the marquee */
        margin: 0 auto 0; /* Centers it horizontally and reduces space below */
        display: block; /* Ensures proper layout alignment */
        margin-bottom: 0%; /* Adjust to control spacing */
    }
    /* Footer */
    .footer-section {
        padding: 70px;
        padding-bottom: 70px;
        color: #000;
    }
    .footer-link h2 {
    color: #000;
    text-align: left;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    white-space: nowrap;
    }
    .footer-link p {
    color: #000;
    line-height: 20px;
    padding: 0px 30px 0px 0px;
    }
    /* Apply two columns only to Featured Links */
    .footer-link.featured-links ul {
    list-style: none;
    padding-left: 0;
    column-count: 2; /* Create two columns */
    column-gap: 2rem; /* Add space between columns */
    }
    .footer-link ul {
    list-style: none;
    padding-left: 0;
    }
    .footer-link ul li {
    margin-bottom: 0.5rem;
    }
    .footer-link ul li a {
    color: #000;
    text-decoration: none;
    }
    .footer-link ul li a:hover {
    color: #007bff;
    }
    .social-icon {
    list-style: none;
    margin-top: 20px;
    }
    .social-icon li {
    float: left;
    padding-left: 10px;
    }
    .social-icon li a i {
    color: #000;
    font-size: 18px;
    padding: 5px 10px;
    }
    .footer-menu {
    padding: 0px;
    width: 100%;
    float: left;
    }
    .footer-menu li {
    width: 50%;
    float: left;
    list-style: none;
    margin-bottom: 10px;
    }
    .footer-menu li a {
    color: #000;
    text-decoration: none;
    }
    .footer-contact {
    list-style: none;
    color: #000;
    padding: 0px;
    float: left;
    width: 100%;
    }
    /* Contact Info Column */
    .footer-link.contact-info ul li {
    font-size: 0.9rem; /* Reduce font size slightly */
    line-height: 1.5; /* Adjust line height for better readability */
    white-space: normal; /* Allow text wrapping if necessary */
    overflow-wrap: break-word; /* Break long words to prevent overflow */
    }
    .footer-contact li {
    width: 100%;
    float: left;
    margin-bottom: 10px;
    }
    .newsletter p {
    margin-bottom: 10px;
    }
    .newsletter input {
    width: 100%;
    float: left;
    padding: 10px;
    }
    .newsletter button {
    width: 100%;
    float: left;
    padding: 10px;
    border: none;
    background-color: gold;
    margin-top: 10px;
    border-radius: 4px;
    }
</style>
@endsection

@section('content')
<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg" style="background-color: #00b2ee;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">SMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Events</a>
                </li>
            </ul>

        <!-- Marquee Section -->
            <div class="marquee-container">
                <marquee behavior="scroll" direction="left">
                    <img src="{{ asset('assets/img/news.gif') }}" alt="news"> Examination Notification
                    <img src="{{ asset('assets/img/news.gif') }}" alt="news"> Get Ready to explore the genius in you
                </marquee>
            </div>

        <!-- Right Side Links -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">
                        <i class="fa fa-bell"></i> Admission Open 
                        <img src="{{ asset('assets/img/news.gif') }}" alt="news">
                    </a>
                </li>
                <li class="nav-item dropdown">
                    @if(Session::has('login') && Session::get('login'))
                        <!-- Dropdown for Logged-in Users -->
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user mr-2"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                            </li>
                        </ul>
                    @else
                        <!-- Login Link for Guests -->
                        <a href="{{ route('login') }}" class="nav-link"><i class="fa fa-user mr-2"></i> Login</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>


<section>
<!-- Banner Section     -->
    <div class="hero-section mb-5">
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-6">
                <h1 class="display-3">My Global University</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam praesentium deleniti ab omnis illo, eaque officia quasi non atque quam molestias repellat fugiat harum exercitationem vel sit inventore, odio distinctio?</p>
                <a href="" class="btn btn-lg btn-primary">Call to Action</a>
                </div>
                <div class="col-lg-6">
                    <div class="col-lg-8 mx-auto card shadow-lg">
                        <div class="card-body py-5">
                        <center><h3>Inquiry Form</h3></center>
                            <form action="" method="post" class="">
                                <!-- Material input -->
                                <div class="md-form">
                                <input type="text" id="form1" class="form-control" placeholder="Your Name" autocomplete="off" required>
                                <label for="form1">Your Name</label>
                                </div>
                                <!-- Material input -->
                                <div class="md-form">
                                <input type="email" id="email" class="form-control" placeholder="Your Email" autocomplete="off" required>
                                <label for="email">Your Email</label>
                                </div>
                                <!-- Material input -->
                                <div class="md-form">
                                <input type="text" id="mobile" class="form-control" placeholder="Your Mobile" autocomplete="off" required>
                                <label for="mobile">Your Mobile</label>
                                </div>
                                <!-- Material input -->
                                <div class="md-form">
                                <!-- <input type="text" id="class" class="form-control"> -->
                                <textarea name="" id="message" class="form-control md-textarea" rows="3" placeholder="Any Queries ?" autocomplete="off" required></textarea>
                                <label for="message">Your Query</label>
                                </div>
                                <button class="btn btn-primary w-100">Submit Form</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 


<!-- About Us -->
    <div class="container mb-5" style="align-items: center; justify-content: center;">
        <div class="row">
            <div class="col-lg-6 py-4">
            <h2>About Us</h2>
            <div>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Porro earum voluptatum esse inventore corporis dignissimos nulla repellendus, consectetur quo voluptate, hic, enim minus quos at minima ut dolore ipsa harum. Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima debitis distinctio dolor doloremque odio, commodi deserunt! Reprehenderit ratione accusamus quidem expedita, atque vel cumque, odio sequi totam corporis distinctio? Natus.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid tempora, dignissimos cum dolorem, numquam quae accusamus omnis reiciendis laudantium cupiditate explicabo error fuga similique impedit officia modi odit. Facilis, debitis.</p>
            </div>
            <a href="#" class="btn btn-primary">Know More</a>
            </div>
            <div class="col-lg-6">
            <img src="assets/img/22.jpeg" alt="About" class="img-fluid">
            </div>
        </div>
    </div>


<!-- Our Courses -->
    <div class="container mb-5">
        <div class="row">
            <center><h2 class="text-center font-weight: bold">Our Courses</h2></center>
            @foreach ($courses as $course)
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <div>
                            <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('images/no-image.png') }}" alt="{{ $course->name }}" class="img-fluid rounded-top">
                        </div>
                        <div class="card-body">
                            <b>{{ $course->name }}</b>
                            <p class="card-text">
                                <b>Duration: </b> {{ $course->duration }}<br>
                                <b>Price: </b> 4000/- Rs
                            </p>
                            <button class="btn btn-primary w-100">Enroll Now</button>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>  


<!-- Our Teachers     -->
    <div class="container mb-5">
        <div class="row">
        <center><h2 class="text-center font-weight-bold">Our Teachers</h2></center>
            <div class="col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                    <img src="assets/img/16.jpeg" alt="" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h5 class="card-title">Teacher's Name</h5>
                    <p class="card-text">
                        <b>Courses: </b> 5 <br>
                        <b>Ratings: </b><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i>
                    </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                    <img src="assets/img/17.jpeg" alt="" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h5 class="card-title">Teacher's Name</h5>
                    <p class="card-text">
                        <b>Courses: </b> 5 <br>
                        <b>Ratings: </b><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i>
                    </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                    <img src="assets/img/18.jpeg" alt="" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h5 class="card-title">Teacher's Name</h5>
                    <p class="card-text">
                        <b>Courses: </b> 5 <br>
                        <b>Ratings: </b><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i>
                    </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                    <img src="assets/img/21.jpeg" alt="" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h5 class="card-title">Teacher's Name</h5>
                    <p class="card-text">
                        <b>Courses: </b> 5 <br>
                        <b>Ratings: </b><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i>
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Achievements -->
    <section style="background:#b2dfee; padding: 2.5rem 0; align-items: center; justify-content: center;"> 
      <div>
        <div class="container">
          <div class="row">
            <!-- Left Section -->
            <div class="col-lg-6">
              <center><h2>Achievements</h2></center>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum a iste sunt culpa libero blanditiis dolore expedita dolorem aliquid, eligendi eaque quaerat rem perferendis, necessitatibus, quas porro ad non nulla.</p>
              <img src="assets/img/23.jpeg" alt="" class="img-fluid rounded" style="height: 350px; width: 550px">
            </div>
            <!-- Right Section -->
            <div class="col-lg-6 my-auto">
              <div class="row">
                <!-- Card 1 -->
                <div class="col-lg-6 mb-3">
                  <div class="border rounded" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body text-center">
                      <span><i class="text-warning fa fa-graduation-cap fa-3x"></i></span>
                      <h4 class="my-2">27,444</h4>
                      <hr class="border-warning">
                      <h5>Graduates</h5>
                    </div>
                  </div>
                </div>
                <!-- Card 2 -->
                <div class="col-lg-6 mb-3">
                  <div class="border rounded" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body text-center">
                      <span><i class="text-warning fa fa-graduation-cap fa-3x"></i></span>
                      <h4 class="my-2">27,444</h4>
                      <hr class="border-warning">
                      <h5>Graduates</h5>
                    </div>
                  </div>
                </div>
                <!-- Card 3 -->
                <div class="col-lg-6 mb-3">
                  <div class="border rounded" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body text-center">
                      <span><i class="text-warning fa fa-graduation-cap fa-3x"></i></span>
                      <h4 class="my-2">27,444</h4>
                      <hr class="border-warning">
                      <h5>Graduates</h5>
                    </div>
                  </div>
                </div>
                <!-- Card 4 -->
                <div class="col-lg-6 mb-3">
                  <div class="border rounded" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body text-center">
                      <span><i class="text-warning fa fa-graduation-cap fa-3x"></i></span>
                      <h4 class="my-2">27,444</h4>
                      <hr class="border-warning">
                      <h5>Graduates</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


<!-- Gallery -->
    <div class="container mb-5">
        <center><h2 class="text-center font-weight-bold m-5">Gallery</h2></center> 
        <div class="gallery">
            <img src="assets/img/g1.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g2.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g3.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g4.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g5.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g6.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g7.jpg" alt="" class="img-fluid rounded">
            <img src="assets/img/g8.jpg" alt="" class="img-fluid rounded">
        </div>
    </div>


<!-- Placements -->
    <div class="placement width-100" style="background:#b2dfee;"> 
        <div class="container mb-5">
            <div class="row"> 
                <div class="col-md-6"> 
                    <div class="placement-sect mt-50">
                    <h2>Placements</h2>
                    <p>2024-2025</p>
                    <p>Offer Higher Package of 36 LPA*</p>
                    <p>Salary include all</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="placement-company mt-50 d-flex flex-wrap"> 
                    <img src="assets/img/c1.jpg">
                    <img src="assets/img/c2.jpg">
                    <img src="assets/img/c3.jpg">
                    <img src="assets/img/c4.jpg">
                    <img src="assets/img/c5.jpg">
                    <img src="assets/img/c6.jpg">
                    <img src="assets/img/c7.jpg">
                    <img src="assets/img/c8.jpg">
                    <img src="assets/img/c9.jpg">
                    <img src="assets/img/c10.jpg">
                    <img src="assets/img/c11.jpg">
                    <img src="assets/img/c12.jpg">
                    <img src="assets/img/c13.jpg">
                    <img src="assets/img/c14.jpg">
                    <img src="assets/img/c15.jpg">
                    <img src="assets/img/c16.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Testimonials -->
    <div class="main-section">
        <div class="container mb-5">
        <center><h2 class="text-center font-weight-bold  m-5">What Students Say About Us</h2></center>
            <marquee behavior="scroll" amount="12" >
                <table>
                    <tr>
                        <td style="width:100px">
                            <div class="testimonial">
                            <div class="testimonial-content"><i class="fa fa-quote-left"></i>
                            Lorem ipsum dolor sit, amet consectetur adipisicing.<br>
                            Ipsum necessitatibus eligendi quidem exercitationem vero.<br> 
                            Provident adipisci voluptatum asperiores aut quo<br> 
                            </div>
                            <div class="testimonial-detail">
                                <div class="testimonial-img">
                                <img src="assets/img/24.jpeg">
                                </div>
                                <div class="testimonial-name">
                                <h5>John Dove</h5>
                                <p>Data Analysis</p>
                                </div>
                            </div>
                            </div>
                        </td>

                        <td style="width:100px">
                            <div class="testimonial">
                            <div class="testimonial-content"><i class="fa fa-quote-left"></i>
                            Lorem ipsum dolor sit, amet consectetur adipisicing.<br>
                            Ipsum necessitatibus eligendi quidem exercitationem vero.<br> 
                            Provident adipisci voluptatum asperiores aut quo<br> 
                            </div>
                            <div class="testimonial-detail">
                                <div class="testimonial-img">
                                <img src="assets/img/26.jpeg">
                                </div>
                                <div class="testimonial-name">
                                <h5>John Dove</h5>
                                <p>Data Analysis</p>
                                </div>
                            </div>
                            </div>
                        </td>

                        <td style="width:100px">
                            <div class="testimonial">
                            <div class="testimonial-content"><i class="fa fa-quote-left"></i>
                            Lorem ipsum dolor sit, amet consectetur adipisicing.<br>
                            Ipsum necessitatibus eligendi quidem exercitationem vero.<br> 
                            Provident adipisci voluptatum asperiores aut quo<br> 
                            </div>
                            <div class="testimonial-detail">
                                <div class="testimonial-img">
                                <img src="assets/img/25.jpeg">
                                </div>
                                <div class="testimonial-name">
                                <h5>John Dove</h5>
                                <p>Data Analysis</p>
                                </div>
                            </div>
                            </div>
                        </td>

                        <td style="width:100px">
                            <div class="testimonial">
                            <div class="testimonial-content"><i class="fa fa-quote-left"></i>
                            Lorem ipsum dolor sit, amet consectetur adipisicing.<br>
                            Ipsum necessitatibus eligendi quidem exercitationem vero.<br> 
                            Provident adipisci voluptatum asperiores aut quo<br> 
                            </div>
                            <div class="testimonial-detail">
                                <div class="testimonial-img">
                                <img src="assets/img/27.jpeg">
                                </div>
                                <div class="testimonial-name">
                                <h5>John Dove</h5>
                                <p>Data Analysis</p>
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </marquee>
        </div>
    </div>  


<!-- Footer -->
    <div class="placement width-100 py-3 mt-3" style="background:#b2dfee;">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                <div class="footer-link">
                    <h2>My Global Campus</h2>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock.</p>
                    <ul class="social-icon">
                    <li><a href="#"><i class="bi bi-twitter" style="color: #007bff;"></i></a></li>
                    <li><a href="#"><i class="bi bi-whatsapp" style="color: green;"></i></a></li>
                    <li><a href="#"><i class="bi bi-facebook" style="color: #3b5998;"></i></a></li>
                    <li><a href="#"><i class="bi bi-linkedin" style="color: #0077b5;"></i></a></li>
                    </ul>
                </div>
                </div>

                <div class="col-md-3">
                <div class="footer-link featured-links">
                    <h2>Featured Links</h2>
                    <ul class="list-unstyled">
                    <li><a href="#">Graduation</a></li>
                    <li><a href="#">Admission</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">International</a></li>
                    <li><a href="#">Graduation</a></li>
                    <li><a href="#">Admission</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">International</a></li>
                    </ul>
                </div>
                </div>

                <div class="col-md-3">
                <div class="footer-link contact-info">
                    <h2>Contact Info</h2>
                    <ul class="list-unstyled">
                    <li><i class="bi bi-envelope-fill"></i> E-MAIL: info@dezven.com</li>
                    <li><i class="bi bi-whatsapp"></i> WHATS-APP: +91 -123 456 789</li>
                    <li><i class="bi bi-telephone-fill"></i> CONTACT NO.: +91 -123 4567890</li>
                    <li><i class="bi bi-globe2"></i> WEBSITE: https://www.dezven.com</li>
                    </ul>
                </div>
                </div>

                <div class="col-md-3">
                <div class="footer-link">
                    <h2>Newsletter</h2>
                    <p>Welcome To The Best Private University</p>
                    <form>
                    <div class="mb-3">
                        <input type="text" name="" class="form-control" placeholder="E-Mail">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Subscribe Now</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

</section>
    
@endsection




