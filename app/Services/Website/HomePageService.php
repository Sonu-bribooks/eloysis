<?php

namespace App\Services\Website;

class HomePageService
{
    /**
     * Get Home Page Data
     */
    public function getPageData(): array
    {
        return [

            'institute' => $this->getInstitute(),

            'sliders' => $this->getSliders(),

            'quick_links' => $this->getQuickLinks(),

            'about' => $this->getAbout(),

            'features' => $this->getFeatures(),

            'classes' => $this->getClasses(),

            'statistics' => $this->getStatistics(),

            'news' => $this->getNews(),

            'events' => $this->getEvents(),

            'principal' => $this->getPrincipal(),

            'gallery' => $this->getGallery(),

            'footer' => $this->getFooter(),

            'testimonials' => $this->getTestimonials(),

            'contact' => $this->getContact(),

        ];
    }

    private function getInstitute(): array
    {

        // WebsiteSetting::first()
        return [

            'name' => 'ABC Public School',

            'tagline' => 'Learn Today, Lead Tomorrow',

            'logo' => asset('assets/website/images/logo.png'),

        ];
    }

    private function getSliders(): array
    {
        return [

            [
                'title' => 'Welcome To ABC Public School',

                'subtitle' => 'Empowering Students Through Quality Education',

                'image' => asset('assets/website/images/slider/slider-1.png'),

                'button_text' => 'Admission Open',

                'button_url' => '#',
            ],

            [
                'title' => 'Online Examination System',

                'subtitle' => 'Smart, Secure and Digital Examination Platform',

                'image' => asset('assets/website/images/slider/slider-2.png'),

                'button_text' => 'Explore',

                'button_url' => '#',
            ],

        ];
    }

    private function getQuickLinks(): array
    {
        return [

            [
                'title' => 'Admission Open',
                'description' => 'Apply for new admission.',
                'icon' => 'bi bi-mortarboard-fill',
                'url' => '#',
                'color' => 'primary',
            ],

            [
                'title' => 'Online Exam',
                'description' => 'Start your online examination.',
                'icon' => 'bi bi-laptop',
                'url' => '#',
                'color' => 'success',
            ],

            [
                'title' => 'Latest Result',
                'description' => 'Check examination results.',
                'icon' => 'bi bi-award-fill',
                'url' => '#',
                'color' => 'warning',
            ],

        ];
    }

    private function getAbout(): array
    {
        return [

            'title' => 'About Our Institute',

            'subtitle' => 'Excellence in Education Since 2010',

            'description' => 'ABC Public School is committed to providing quality education with modern teaching methods, experienced faculty, and a technology-driven learning environment. Our goal is to develop students academically, socially, and morally.',

            'image' => asset('assets/website/images/slider/slider-2.png'),

            'button_text' => 'Read More',

            'button_url' => '#',

        ];
    }

    private function getFeatures(): array
    {
        return [

            [
                'icon' => 'bi bi-mortarboard-fill',
                'title' => 'Expert Teachers',
                'description' => 'Experienced and qualified faculty members.',
            ],

            [
                'icon' => 'bi bi-laptop',
                'title' => 'Smart Classes',
                'description' => 'Technology-enabled interactive classrooms.',
            ],

            [
                'icon' => 'bi bi-book-fill',
                'title' => 'Digital Library',
                'description' => 'Access to books and digital learning resources.',
            ],

            [
                'icon' => 'bi bi-pencil-square',
                'title' => 'Online Exams',
                'description' => 'Secure and fast online examination system.',
            ],

            [
                'icon' => 'bi bi-award-fill',
                'title' => 'Best Results',
                'description' => 'Excellent academic performance every year.',
            ],

            [
                'icon' => 'bi bi-dribbble',
                'title' => 'Sports Activities',
                'description' => 'Overall development through sports and games.',
            ],

        ];
    }

    private function getClasses(): array
    {
        return [

            ['name' => 'Class 1',  'students' => 40],
            ['name' => 'Class 2',  'students' => 42],
            ['name' => 'Class 3',  'students' => 38],
            ['name' => 'Class 4',  'students' => 45],
            ['name' => 'Class 5',  'students' => 41],
            ['name' => 'Class 6',  'students' => 39],
            ['name' => 'Class 7',  'students' => 44],
            ['name' => 'Class 8',  'students' => 40],
            ['name' => 'Class 9',  'students' => 37],
            ['name' => 'Class 10', 'students' => 43],
            ['name' => 'Class 11', 'students' => 35],
            ['name' => 'Class 12', 'students' => 30],

        ];
    }

    private function getStatistics(): array
    {
        return [
            [
                'count' => '2500+',
                'title' => 'Students',
                'icon' => 'bi bi-people-fill',
            ],
            [
                'count' => '120+',
                'title' => 'Teachers',
                'icon' => 'bi bi-person-workspace',
            ],
            [
                'count' => '12',
                'title' => 'Classes',
                'icon' => 'bi bi-building',
            ],
            [
                'count' => '98%',
                'title' => 'Result',
                'icon' => 'bi bi-trophy-fill',
            ],
        ];
    }

    private function getNews(): array
    {
        return [

            [
                'title' => 'Admission Open for Session 2026-27',
                'image' => 'news/news-1.jpg',
                'date' => '26 Jun 2026',
                'description' => 'Admissions are now open for all classes. Apply before the last date.',
                'url' => '#',
            ],

            [
                'title' => 'Annual Sports Day Celebration',
                'image' => 'news/news-2.jpeg',
                'date' => '20 Jun 2026',
                'description' => 'Students participated in various sports activities with great enthusiasm.',
                'url' => '#',
            ],

            [
                'title' => 'Class 10 Board Result Declared',
                'image' => 'news/news-3.jpg',
                'date' => '15 Jun 2026',
                'description' => 'Congratulations to all students for achieving excellent results.',
                'url' => '#',
            ],

        ];
    }

    private function getEvents(): array
    {
        return [

            [
                'date' => '05',
                'month' => 'JUL',
                'title' => 'Science Exhibition',
                'time' => '10:00 AM',
                'location' => 'School Campus',
                'url' => '#',
            ],

            [
                'date' => '15',
                'month' => 'JUL',
                'title' => 'Parents Teacher Meeting',
                'time' => '09:30 AM',
                'location' => 'Conference Hall',
                'url' => '#',
            ],

            [
                'date' => '25',
                'month' => 'JUL',
                'title' => 'Annual Sports Competition',
                'time' => '08:00 AM',
                'location' => 'Play Ground',
                'url' => '#',
            ],

        ];
    }

    private function getPrincipal(): array
    {
        return [

            'name' => 'Dr. Rajesh Kumar',

            'designation' => 'Principal',

            'image' => 'principal/principal.jpg',

            'message' => 'Welcome to ABC Public School. Our mission is to provide quality education that inspires students to become responsible citizens and lifelong learners. We focus on academic excellence, discipline, innovation, and overall personality development.',

            'signature' => 'principal/signature.png',

        ];
    }

    private function getGallery(): array
    {
        return [

            ['image' => 'gallery/gallery-1.jpg'],
            ['image' => 'gallery/gallery-2.jpg'],
            ['image' => 'gallery/gallery-3.jpg'],
            ['image' => 'gallery/gallery-4.jpg'],
            ['image' => 'gallery/gallery-5.jpg'],
            ['image' => 'gallery/gallery-6.jpg'],

        ];
    }

    private function getFooter(): array
    {
        return [

            'about' => [
                'title' => 'ABC Public School',
                'description' => 'ABC Public School is committed to providing quality education with modern learning methods and overall student development.',
            ],

            'quick_links' => [
                ['title' => 'Home', 'url' => route('home')],
                ['title' => 'About Us', 'url' => '#about'],
                ['title' => 'Classes', 'url' => '#classes'],
                ['title' => 'Gallery', 'url' => '#gallery'],
                ['title' => 'Contact', 'url' => '#contact'],
            ],

            'contact' => [
                'address' => 'New Delhi, India',
                'phone' => '+91 9876543210',
                'email' => 'info@abcschool.com',
            ],

            'social' => [
                'facebook' => '#',
                'instagram' => '#',
                'youtube' => '#',
                'linkedin' => '#',
            ],

            'copyright' => '© '.date('Y').' ABC Public School. All Rights Reserved.',
        ];
    }

    private function getTestimonials(): array
    {
        return [

            [
                'name' => 'Amit Sharma',
                'role' => 'Parent',
                'image' => 'testimonials/parent-1.jpg',
                'message' => 'The school provides an excellent learning environment. My child has improved academically and personally.',
                'rating' => 5,
            ],

            [
                'name' => 'Priya Verma',
                'role' => 'Student',
                'image' => 'testimonials/student-1.jpg',
                'message' => 'Teachers are supportive and the online exam system is very easy to use.',
                'rating' => 5,
            ],

            [
                'name' => 'Rahul Singh',
                'role' => 'Parent',
                'image' => 'testimonials/parent-2.jpg',
                'message' => 'Best school with modern facilities, discipline, and excellent teachers.',
                'rating' => 5,
            ],

        ];
    }

    private function getContact(): array
    {
        return [

            'title' => 'Get In Touch',

            'subtitle' => 'Contact Us',

            'address' => 'ABC Public School, New Delhi, India',

            'phone' => '+91 9876543210',

            'email' => 'info@abcschool.com',

            'working_hours' => 'Mon - Sat : 08:00 AM - 04:00 PM',

            'map' => 'https://maps.google.com',

        ];
    }
}
