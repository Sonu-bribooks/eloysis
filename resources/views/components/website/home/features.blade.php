<section id="features"  class="features-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="about-subtitle">
                WHY CHOOSE US
            </span>

            <h2 class="about-title">
                Why Students Choose Our Institute
            </h2>

        </div>

        <div class="row">

            @foreach($pageData['features'] as $feature)

            <div class="col-lg-4 col-md-6 mb-4">

                <div class="feature-card">

                    <div class="feature-icon">

                        <i class="{{ $feature['icon'] }}"></i>

                    </div>

                    <h4>{{ $feature['title'] }}</h4>

                    <p>{{ $feature['description'] }}</p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>