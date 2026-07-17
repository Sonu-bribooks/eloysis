<section id="testimonials" class="testimonial-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="about-subtitle">
                TESTIMONIALS
            </span>

            <h2 class="about-title">
                What People Say About Us
            </h2>

        </div>

        <div class="row">

            @foreach($pageData['testimonials'] as $testimonial)

            <div class="col-lg-4 col-md-6 mb-4">

                <div class="testimonial-card">

                    <img
                        src="{{ asset('assets/website/images/'.$testimonial['image']) }}"
                        alt="{{ $testimonial['name'] }}"
                        class="testimonial-image">

                    <div class="rating">
                        @for($i = 1; $i <= $testimonial['rating']; $i++)
                            <i class="bi bi-star-fill"></i>
                            @endfor
                    </div>

                    <p class="testimonial-message">
                        "{{ $testimonial['message'] }}"
                    </p>

                    <h5>{{ $testimonial['name'] }}</h5>

                    <small>{{ $testimonial['role'] }}</small>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>