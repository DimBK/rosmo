@extends('layouts.app')

@section('body_class', 'testimonials-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>Testimonials</h1>
        <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Testimonials</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Slider Testimonials Section -->
    <section id="slider-testimonials" class="slider-testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <div><span>Check Our</span> <span class="description-title">Testimonials</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="testimonials-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "slidesPerView": 1,
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              }
            }
          </script>

          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row">
                  <div class="col-lg-8">
                    <h2>Sed ut perspiciatis unde omnis</h2>
                    <p>
                      Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                    </p>
                    <p>
                      Beatae magnam dolore quia ipsum. Voluptatem totam et qui dolore dignissimos. Amet quia sapiente laudantium nihil illo et assumenda sit cupiditate. Nam perspiciatis perferendis minus consequatur. Enim ut eos quo.
                    </p>
                    <div class="profile d-flex align-items-center">
                      <img src="{{ asset('assets/img/person/person-m-7.webp') }}" class="profile-img" alt="">
                      <div class="profile-info">
                        <h3>Saul Goodman</h3>
                        <span>Client</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 d-none d-lg-block">
                    <div class="featured-img-wrapper">
                      <img src="{{ asset('assets/img/person/person-m-7.webp') }}" class="featured-img" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Testimonial Item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row">
                  <div class="col-lg-8">
                    <h2>Nemo enim ipsam voluptatem</h2>
                    <p>
                      Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                    </p>
                    <p>
                      Dolorem excepturi esse qui amet maxime quibusdam aut repellendus voluptatum. Corrupti enim a repellat cumque est laborum fuga consequuntur. Dolorem nostrum deleniti quas voluptatem iure dolorum rerum. Repudiandae doloribus ut repellat harum vero aut. Modi aut velit aperiam aspernatur odit ut vitae.
                    </p>
                    <div class="profile d-flex align-items-center">
                      <img src="{{ asset('assets/img/person/person-f-8.webp') }}" class="profile-img" alt="">
                      <div class="profile-info">
                        <h3>Sara Wilsson</h3>
                        <span>Designer</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 d-none d-lg-block">
                    <div class="featured-img-wrapper">
                      <img src="{{ asset('assets/img/person/person-f-8.webp') }}" class="featured-img" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Testimonial Item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row">
                  <div class="col-lg-8">
                    <h2>
                      Labore nostrum eos impedit
                    </h2>
                    <p>
                      Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                    </p>
                    <p>
                      Itaque ut explicabo vero occaecati est quam rerum sed. Numquam tempora aut aut quaerat quia illum. Nobis quia autem odit ipsam numquam. Doloribus sit sint corporis eius totam fuga. Hic nostrum suscipit corrupti nam expedita adipisci aut optio.
                    </p>
                    <div class="profile d-flex align-items-center">
                      <img src="{{ asset('assets/img/person/person-m-9.webp') }}" class="profile-img" alt="">
                      <div class="profile-info">
                        <h3>Matt Brandon</h3>
                        <span>Freelancer</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 d-none d-lg-block">
                    <div class="featured-img-wrapper">
                      <img src="{{ asset('assets/img/person/person-m-9.webp') }}" class="featured-img" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Testimonial Item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row">
                  <div class="col-lg-8">
                    <h2>Impedit dolor facilis nulla</h2>
                    <p>
                      Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                    </p>
                    <p>
                      Omnis aspernatur accusantium qui delectus praesentium repellendus. Facilis sint odio aspernatur voluptas commodi qui qui qui pariatur. Corrupti deleniti itaque quaerat ipsum deleniti culpa tempora tempore. Et consequatur exercitationem hic aspernatur nobis est voluptatibus architecto laborum.
                    </p>
                    <div class="profile d-flex align-items-center">
                      <img src="{{ asset('assets/img/person/person-f-10.webp') }}" class="profile-img" alt="">
                      <div class="profile-info">
                        <h3>Jena Karlis</h3>
                        <span>Store Owner</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 d-none d-lg-block">
                    <div class="featured-img-wrapper">
                      <img src="{{ asset('assets/img/person/person-f-10.webp') }}" class="featured-img" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Testimonial Item -->

          </div>

          <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>

        </div>

      </div>

    </section><!-- /Slider Testimonials Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <div class="container">

        <div class="testimonial-masonry">

          <div class="testimonial-item" data-aos="fade-up">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Implementing innovative strategies has revolutionized our approach to market challenges and competitive positioning.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="{{ asset('assets/img/person/person-f-7.webp') }}" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Rachel Bennett</h3>
                  <span class="position">Strategy Director</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item highlight" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Exceptional service delivery and innovative solutions have transformed our business operations, leading to remarkable growth and enhanced customer satisfaction across all touchpoints.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="{{ asset('assets/img/person/person-m-7.webp') }}" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Daniel Morgan</h3>
                  <span class="position">Chief Innovation Officer</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="200">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Strategic partnership has enabled seamless digital transformation and operational excellence.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="{{ asset('assets/img/person/person-f-8.webp') }}" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Emma Thompson</h3>
                  <span class="position">Digital Lead</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Professional expertise and dedication have significantly improved our project delivery timelines and quality metrics.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="{{ asset('assets/img/person/person-m-8.webp') }}" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Christopher Lee</h3>
                  <span class="position">Technical Director</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item highlight" data-aos="fade-up" data-aos-delay="400">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Collaborative approach and industry expertise have revolutionized our product development cycle, resulting in faster time-to-market and increased customer engagement levels.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="{{ asset('assets/img/person/person-f-9.webp') }}" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Olivia Carter</h3>
                  <span class="position">Product Manager</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="500">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Innovative approach to user experience design has significantly enhanced our platform's engagement metrics and customer retention rates.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="{{ asset('assets/img/person/person-m-13.webp') }}" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Nathan Brooks</h3>
                  <span class="position">UX Director</span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Testimonials Section -->

  </main>
@endsection
