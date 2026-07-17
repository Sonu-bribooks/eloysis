<section id="events" class="events-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="about-subtitle">
                UPCOMING EVENTS
            </span>

            <h2 class="about-title">
                Don't Miss Our Events
            </h2>

        </div>

        <div class="row">

            @foreach($pageData['events'] as $event)

            <div class="col-lg-4 mb-4">

                <div class="event-card">

                    <div class="event-date">

                        <span>{{ $event['date'] }}</span>

                        <small>{{ $event['month'] }}</small>

                    </div>

                    <div class="event-content">

                        <h5>{{ $event['title'] }}</h5>

                        <p>

                            <i class="bi bi-clock"></i>

                            {{ $event['time'] }}

                        </p>

                        <p>

                            <i class="bi bi-geo-alt"></i>

                            {{ $event['location'] }}

                        </p>

                        <a href="{{ $event['url'] }}" class="btn btn-primary btn-sm">

                            View Details

                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>