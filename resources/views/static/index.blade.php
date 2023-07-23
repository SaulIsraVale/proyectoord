@extends("static.base")

@section("title", "Cybershop")

@section("content")

    <script src="https://unpkg.com/htmx.org@1.9.3" integrity="sha384-lVb3Rd/Ca0AxaoZg5sACe8FJKF0tnUgR2Kd7ehUOG5GCcROv5uBIZsOqovBAcWua" crossorigin="anonymous"></script>
    
    <link href="/assets/vendor/glightbox/css/glightbox.css" rel="stylesheet">

    <body>
        <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"  data-aos-delay="200">
                    <h1>E-commerce</h1>
                    <h2>An e-Business website with Laravel & MariaDB for the backend, and Bootstrap for the front-end</h2>
                    
                </div>

                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="assets/img/hero-img.webp" class="img-fluid animated" style="margin-left: 20%; height: 60%; margin-top: 20%;" alt="">
                </div>
            </div>
        </div>

        </section>

        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-laptop">Laptops & Tablets</li>
                            <li data-filter=".filter-gaming">Gaming accessories</li>
                            <li data-filter=".filter-food">Food</li>
                            <li data-filter=".filter-dresses">Dresses</li>
                            <li data-filter=".filter-other">Other picks</li>      
                        </ul>
                    </div>
                </div>


                <div class="row portfolio-container">
                    @foreach($products as $d)


                        <div class="col-md-3 portfolio-item {{ $d['class'] }}">
                            <div class="portfolio-wrap" style="border-radius: 5px; flex-direction: column;">
                                <a href="/details/{{ $d['id'] }}">
                                    <img 

                                    data-src="/storage/product_img/{{ $d['image'] }}" 
                                    class="img-fluid imgpres" alt="">
                                </a>
                                <div class="portfoliodetails">
                                    <strong>{{$d['price']}} $</strong>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>

                <button class="buttonpag" hx-get="{{ $products -> nextPageUrl() }}" hx-swap="outerHTML" >
                    <span class="paginationbutton">
                        <span class="spinner-border spinner-border-sm htmx-indicator" role="status" aria-hidden="true"></span>
                        More products
                    </span>
                </button>
            </div>
        </section>

    
    @if(session("deletedproduct"))
            <script>
                success("{{ session('deletedproduct') }}", "Deleted")
            </script>
    @endif

    @if(session("deletedaccount"))
        <script>success("Your account has been removed permanently.", "Deleted")</script>
    @endif
@endsection

{{-- 
    Load les images uniquement lorsque la page
    a fini de se charger.
    Permet de gagner énormement de temps
--}}

<script>
    window.addEventListener('load', function() {
        var images = document.getElementsByTagName('img');
        for (var i = 0; i < images.length; i++) {
        var img = images[i];
        if (img.getAttribute('data-src')) {
            img.setAttribute('src', img.getAttribute('data-src'));
        }
        }
    });
</script>

