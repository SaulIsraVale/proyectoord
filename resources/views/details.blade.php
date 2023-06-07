<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{$data["name"]}}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  @include('../layout/header')

  
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs" style="padding-top: 86px; padding-bottom: 0px !important;">
      <div class="container">

        <ol></ol>
        <h2>{{$data["name"]}}</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">


                  <img style="width: 60% !important;" src="../storage/product_img/{{ $data["image"] }}.png" alt="">

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4"  style="color: white; background-color: #293e61 !important; border-radius: 12px;">
            <div class="portfolio-info" style="padding-bottom: 10px;" >
              <h2>Product information</h2>
              <hr>
              <ul>
                <?php
                  // Get all the categories 
                  $allcateg = explode(' ', $data["class"]);
                
                  // Parcourir + assigner
                  $todisplay = "";

                  foreach($allcateg as $categ){
                    $todisplay .= ucfirst(explode('-', $categ)[1]) . ", ";
                  }

                  $todisplay = trim($todisplay, ", ")

                ?>
                
                <li><strong>Category</strong>: {{ $todisplay }}</li>
                <li><strong>Seller</strong>: {{ $data['mail'] }}</li>
                <li><strong>Price</strong>: {{ $data['price'] }}$</li>
                <br>
                <h3></h3>
              </ul>
            </div>
            <div class="portfolio-info">
              <p class="descr">
                {{ $data['descr'] }}
              </p> 

            </div>
            
            <form class="navbar" method="post" action="/add">        
              <input class="addtocart" type="submit" value="Add to cart">
              <input type="hidden" value="{{$data['pid']}}">
            </form>
          
          </div>
          

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->
    <hr>

    <section id="breadcrumbs" style="padding-top: 1%;" class="breadcrumbs">
      <div class="container">

        <ol></ol>
        <h2>Comments</h2>

      </div>
    </section><!-- End Breadcrumbs -->

  </main><!-- End #main -->


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>