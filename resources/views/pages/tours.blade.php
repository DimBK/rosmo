@extends('layouts.app')

@section('body_class', 'tours-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>Tours</h1>
        <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Tours</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Travel Tours Section -->
    <section id="travel-tours" class="travel-tours section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto text-center mb-5">
            <h2>Find Your Perfect Tour</h2>
            <p>Discover unforgettable travel experiences with our curated collection of tours. Explore by destination, travel style, or date to find the adventure that's perfect for you.</p>
          </div>
        </div>

        <!-- Tour Filters -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="200">
          <div class="col-12">
            <div class="tour-filters">
              <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                  <select class="form-select">
                    <option value="">Select Destination</option>
                    <option value="paris">Paris</option>
                    <option value="bali">Bali</option>
                    <option value="tokyo">Tokyo</option>
                    <option value="rome">Rome</option>
                    <option value="thailand">Thailand</option>
                  </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <select class="form-select">
                    <option value="">Tour Type</option>
                    <option value="adventure">Adventure</option>
                    <option value="luxury">Luxury</option>
                    <option value="family">Family</option>
                    <option value="cultural">Cultural</option>
                    <option value="beach">Beach</option>
                  </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <select class="form-select">
                    <option value="">Duration</option>
                    <option value="1-3">1-3 Days</option>
                    <option value="4-7">4-7 Days</option>
                    <option value="8-14">8-14 Days</option>
                    <option value="15+">15+ Days</option>
                  </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <select class="form-select">
                    <option value="">Price Range</option>
                    <option value="0-500">$0 - $500</option>
                    <option value="500-1000">$500 - $1,000</option>
                    <option value="1000-2000">$1,000 - $2,000</option>
                    <option value="2000+">$2,000+</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Featured Tours Slider -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="300">
          <div class="col-12">
            <h3 class="section-subtitle mb-4">Featured Tours</h3>
            <div class="featured-tours-slider swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 1,
                  "spaceBetween": 30,
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "768": {
                      "slidesPerView": 2
                    },
                    "1200": {
                      "slidesPerView": 3
                    }
                  }
                }
              </script>
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-15.webp') }}" alt="Bali Adventure" class="img-fluid">
                      <div class="tour-badge">Best Seller</div>
                    </div>
                    <div class="tour-content">
                      <h4>Bali Adventure Escape</h4>
                      <p>Discover the mystical beauty of Bali with temple visits, volcano hiking, and pristine beaches.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 7 Days</span>
                        <span class="price">From $899</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-22.webp') }}" alt="Paris Romance" class="img-fluid">
                      <div class="tour-badge">Luxury</div>
                    </div>
                    <div class="tour-content">
                      <h4>Romantic Paris Getaway</h4>
                      <p>Experience the city of love with premium accommodations and exclusive dining.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 5 Days</span>
                        <span class="price">From $1299</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-8.webp') }}" alt="Tokyo Culture" class="img-fluid">
                      <div class="tour-badge">New</div>
                    </div>
                    <div class="tour-content">
                      <h4>Tokyo Cultural Experience</h4>
                      <p>Immerse yourself in Japanese culture, from traditional tea ceremonies to modern city life.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 10 Days</span>
                        <span class="price">From $1599</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-14.webp') }}" alt="Norwegian Fjords" class="img-fluid">
                      <div class="tour-badge">Popular</div>
                    </div>
                    <div class="tour-content">
                      <h4>Norwegian Fjords Cruise</h4>
                      <p>Sail through dramatic fjords and witness the stunning landscapes of Norway's coastline.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 9 Days</span>
                        <span class="price">From $1899</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-7.webp') }}" alt="Egyptian Adventure" class="img-fluid">
                      <div class="tour-badge">Cultural</div>
                    </div>
                    <div class="tour-content">
                      <h4>Ancient Egypt Explorer</h4>
                      <p>Journey through time visiting pyramids, temples, and sailing the legendary Nile River.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 8 Days</span>
                        <span class="price">From $1149</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-19.webp') }}" alt="Costa Rica Adventure" class="img-fluid">
                      <div class="tour-badge">Adventure</div>
                    </div>
                    <div class="tour-content">
                      <h4>Costa Rica Eco Adventure</h4>
                      <p>Experience rainforest canopy tours, wildlife viewing, and pristine beaches in this eco paradise.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 6 Days</span>
                        <span class="price">From $749</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-2.webp') }}" alt="Greek Islands" class="img-fluid">
                      <div class="tour-badge">Summer Special</div>
                    </div>
                    <div class="tour-content">
                      <h4>Greek Islands Hopping</h4>
                      <p>Explore the stunning Greek islands, from Santorini's sunsets to Mykonos' vibrant nightlife.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 11 Days</span>
                        <span class="price">From $1399</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      <img src="{{ asset('assets/img/travel/tour-25.webp') }}" alt="Patagonia Trek" class="img-fluid">
                      <div class="tour-badge">Extreme</div>
                    </div>
                    <div class="tour-content">
                      <h4>Patagonia Wilderness Trek</h4>
                      <p>Challenge yourself in one of the world's last great wildernesses with glaciers and mountain peaks.</p>
                      <div class="tour-meta">
                        <span class="duration"><i class="bi bi-clock"></i> 12 Days</span>
                        <span class="price">From $2299</span>
                      </div>
                      <a href="{{ url('tour-details') }}" class="btn btn-primary">View Details</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>

        <!-- Tour Categories -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="400">
          <div class="col-12">
            <h3 class="section-subtitle mb-4">Browse by Category</h3>
            <div class="row">
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="category-card">
                  <div class="category-icon">
                    <i class="bi bi-compass"></i>
                  </div>
                  <h5>Adventure</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="category-card">
                  <div class="category-icon">
                    <i class="bi bi-gem"></i>
                  </div>
                  <h5>Luxury</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="category-card">
                  <div class="category-icon">
                    <i class="bi bi-people"></i>
                  </div>
                  <h5>Family</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="category-card">
                  <div class="category-icon">
                    <i class="bi bi-palette"></i>
                  </div>
                  <h5>Cultural</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="category-card">
                  <div class="category-icon">
                    <i class="bi bi-sun"></i>
                  </div>
                  <h5>Beach</h5>
                </div>
              </div>
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="category-card">
                  <div class="category-icon">
                    <i class="bi bi-building"></i>
                  </div>
                  <h5>City</h5>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Special Offers -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="500">
          <div class="col-12">
            <div class="special-offers">
              <h3 class="section-subtitle mb-4">Last-Minute Deals</h3>
              <div class="row">
                <div class="col-lg-6 mb-4">
                  <div class="offer-banner">
                    <div class="offer-content">
                      <div class="discount-badge">30% OFF</div>
                      <h4>Mediterranean Cruise</h4>
                      <p>Explore Italy, Greece, and Spain with luxury accommodations and gourmet dining.</p>
                      <span class="urgency">Only 3 seats left!</span>
                      <a href="{{ url('booking') }}" class="btn btn-accent">Book Now</a>
                    </div>
                    <div class="offer-image">
                      <img src="{{ asset('assets/img/travel/misc-12.webp') }}" alt="Cruise" class="img-fluid">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="offer-banner">
                    <div class="offer-content">
                      <div class="discount-badge">25% OFF</div>
                      <h4>African Safari</h4>
                      <p>Witness the great migration and encounter magnificent wildlife in their natural habitat.</p>
                      <span class="urgency">Limited time offer!</span>
                      <a href="{{ url('booking') }}" class="btn btn-accent">Book Now</a>
                    </div>
                    <div class="offer-image">
                      <img src="{{ asset('assets/img/travel/misc-8.webp') }}" alt="Safari" class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tour Grid -->
        <div class="row" data-aos="fade-up" data-aos-delay="600">
          <div class="col-12">
            <h3 class="section-subtitle mb-4">All Tours</h3>
            <div class="row">
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card">
                  <div class="tour-image">
                    <img src="{{ asset('assets/img/travel/tour-3.webp') }}" alt="Swiss Alps" class="img-fluid">
                    <div class="tour-price">$749</div>
                  </div>
                  <div class="tour-content">
                    <h4>Swiss Alps Adventure</h4>
                    <p>Experience breathtaking mountain views and charming alpine villages in the heart of Switzerland.</p>
                    <div class="tour-details">
                      <span><i class="bi bi-clock"></i> 6 Days</span>
                      <span><i class="bi bi-star-fill"></i> 4.8 (124 reviews)</span>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Tour</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card">
                  <div class="tour-image">
                    <img src="{{ asset('assets/img/travel/tour-11.webp') }}" alt="Iceland" class="img-fluid">
                    <div class="tour-price">$1199</div>
                  </div>
                  <div class="tour-content">
                    <h4>Iceland Northern Lights</h4>
                    <p>Chase the aurora borealis and explore ice caves, geysers, and dramatic waterfalls.</p>
                    <div class="tour-details">
                      <span><i class="bi bi-clock"></i> 8 Days</span>
                      <span><i class="bi bi-star-fill"></i> 4.9 (89 reviews)</span>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Tour</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card">
                  <div class="tour-image">
                    <img src="{{ asset('assets/img/travel/tour-18.webp') }}" alt="Morocco" class="img-fluid">
                    <div class="tour-price">$899</div>
                  </div>
                  <div class="tour-content">
                    <h4>Magical Morocco Tour</h4>
                    <p>Discover ancient medinas, sahara desert, and vibrant markets in this exotic destination.</p>
                    <div class="tour-details">
                      <span><i class="bi bi-clock"></i> 9 Days</span>
                      <span><i class="bi bi-star-fill"></i> 4.7 (156 reviews)</span>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Tour</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card">
                  <div class="tour-image">
                    <img src="{{ asset('assets/img/travel/tour-5.webp') }}" alt="Peru" class="img-fluid">
                    <div class="tour-price">$1399</div>
                  </div>
                  <div class="tour-content">
                    <h4>Peru Machu Picchu Trek</h4>
                    <p>Hike the legendary Inca Trail and discover the lost city of Machu Picchu.</p>
                    <div class="tour-details">
                      <span><i class="bi bi-clock"></i> 12 Days</span>
                      <span><i class="bi bi-star-fill"></i> 4.9 (203 reviews)</span>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Tour</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card">
                  <div class="tour-image">
                    <img src="{{ asset('assets/img/travel/tour-26.webp') }}" alt="Vietnam" class="img-fluid">
                    <div class="tour-price">$679</div>
                  </div>
                  <div class="tour-content">
                    <h4>Vietnam Discovery</h4>
                    <p>From bustling Hanoi to serene Ha Long Bay, explore Vietnam's diverse landscapes.</p>
                    <div class="tour-details">
                      <span><i class="bi bi-clock"></i> 10 Days</span>
                      <span><i class="bi bi-star-fill"></i> 4.6 (178 reviews)</span>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Tour</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card">
                  <div class="tour-image">
                    <img src="{{ asset('assets/img/travel/tour-13.webp') }}" alt="Australia" class="img-fluid">
                    <div class="tour-price">$1799</div>
                  </div>
                  <div class="tour-content">
                    <h4>Australia Highlights</h4>
                    <p>Explore Sydney, Melbourne, and the Great Barrier Reef in this comprehensive tour.</p>
                    <div class="tour-details">
                      <span><i class="bi bi-clock"></i> 14 Days</span>
                      <span><i class="bi bi-star-fill"></i> 4.8 (95 reviews)</span>
                    </div>
                    <a href="#" class="btn btn-outline-primary">View Tour</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA Section -->
        <div class="row" data-aos="fade-up" data-aos-delay="700">
          <div class="col-12">
            <div class="cta-section text-center">
              <h3>Not Sure What to Choose?</h3>
              <p>Our travel experts are here to help you find the perfect tour based on your preferences and budget.</p>
              <div class="cta-buttons">
                <a href="#" class="btn btn-primary me-3">Contact Our Experts</a>
                <a href="#" class="btn btn-outline-primary">Take Our Travel Quiz</a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Travel Tours Section -->

  </main>
@endsection
