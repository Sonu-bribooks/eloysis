<footer class="footer">

    <div class="container">

        <div class="row">

            <!-- About -->
            <div class="col-lg-4 mb-4">

                <h4>{{ $pageData['footer']['about']['title'] }}</h4>

                <p>
                    {{ $pageData['footer']['about']['description'] }}
                </p>

                <div class="footer-social">

                    <a href="{{ $pageData['footer']['social']['facebook'] }}">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="{{ $pageData['footer']['social']['instagram'] }}">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="{{ $pageData['footer']['social']['youtube'] }}">
                        <i class="bi bi-youtube"></i>
                    </a>

                    <a href="{{ $pageData['footer']['social']['linkedin'] }}">
                        <i class="bi bi-linkedin"></i>
                    </a>

                </div>

            </div>

            <!-- Quick Links -->
            <div class="col-lg-4 mb-4">

                <h4>Quick Links</h4>

                <ul class="footer-links">

                    @foreach($pageData['footer']['quick_links'] as $link)

                    <li>
                        <a href="{{ $link['url'] }}">
                            {{ $link['title'] }}
                        </a>
                    </li>

                    @endforeach

                </ul>

            </div>

            <!-- Contact -->
            <div class="col-lg-4 mb-4">

                <h4>Contact Us</h4>

                <p>
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ $pageData['footer']['contact']['address'] }}
                </p>

                <p>
                    <i class="bi bi-telephone-fill"></i>
                    {{ $pageData['footer']['contact']['phone'] }}
                </p>

                <p>
                    <i class="bi bi-envelope-fill"></i>
                    {{ $pageData['footer']['contact']['email'] }}
                </p>

            </div>

        </div>

        <hr>

        <div class="text-center">

            {{ $pageData['footer']['copyright'] }}

        </div>

    </div>

</footer>