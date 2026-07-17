<section id="contact" class="contact-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="about-subtitle">

                {{ $pageData['contact']['subtitle'] }}

            </span>

            <h2 class="about-title">

                {{ $pageData['contact']['title'] }}

            </h2>

        </div>

        <div class="row">

            <div class="col-lg-5 mb-4">

                <div class="contact-info">

                    <div class="contact-item">

                        <i class="bi bi-geo-alt-fill"></i>

                        <div>

                            <h5>Address</h5>

                            <p>{{ $pageData['contact']['address'] }}</p>

                        </div>

                    </div>

                    <div class="contact-item">

                        <i class="bi bi-telephone-fill"></i>

                        <div>

                            <h5>Phone</h5>

                            <p>{{ $pageData['contact']['phone'] }}</p>

                        </div>

                    </div>

                    <div class="contact-item">

                        <i class="bi bi-envelope-fill"></i>

                        <div>

                            <h5>Email</h5>

                            <p>{{ $pageData['contact']['email'] }}</p>

                        </div>

                    </div>

                    <div class="contact-item">

                        <i class="bi bi-clock-fill"></i>

                        <div>

                            <h5>Office Hours</h5>

                            <p>{{ $pageData['contact']['working_hours'] }}</p>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-7">

                <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <input  type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Your Name">
                           
                        </div>

                        <div class="col-md-6 mb-3">

                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Your Email">
                           

                        </div>

                    </div>

                    <div class="mb-3">

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Phone Number">

                    </div>

                    <div class="mb-3">

                        <input type="text"
                            name="subject"
                            value="{{ old('subject') }}"
                            class="form-control @error('subject') is-invalid @enderror"
                            placeholder="Subject">

                    </div>

                    <div class="mb-3">

                        <textarea
                            rows="5"
                            name="message"
                            class="form-control @error('message') is-invalid @enderror"
                            placeholder="Message">{{ old('message') }}
                        </textarea>

                    </div>

                    <button type="submit" class="btn btn-primary">

                        Send Message

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>