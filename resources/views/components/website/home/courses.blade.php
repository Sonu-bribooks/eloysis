<section id="classes" class="classes-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="about-subtitle">
                OUR CLASSES
            </span>

            <h2 class="about-title">
                Choose Your Class
            </h2>

        </div>

        <div class="row">

            @foreach($pageData['classes'] as $class)

            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

                <div class="class-card">

                    <div class="class-icon">

                        <i class="bi bi-book-half"></i>

                    </div>

                    <h5>{{ $class['name'] }}</h5>

                    <p>{{ $class['students'] }} Students</p>

                    <a href="#" class="btn btn-outline-primary btn-sm">

                        View Details

                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>