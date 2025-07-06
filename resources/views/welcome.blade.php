<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>PW KALTIM @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('image/logo.png') }}" type="image/x-icon">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Toastr -->


</head>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<body>
    <nav class="bg-green-900 fixed top-0 left-0 w-full z-50 shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="text-white text-lg font-bold">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10">
                    </a>

                </div>

                <!-- Menu toggle for mobile -->
                <div class="flex lg:hidden">
                    <button id="menu-toggle" class="text-white focus:outline-none focus:ring-2 focus:ring-white ">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="hidden lg:flex space-x-4">
                    @if (Route::has('login'))
                    <a href="/" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="#home" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">About</a>
                    <a href="#profil" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Profil</a>
                    <a href="#persyaratan" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Informasi</a>
                    @auth
                    <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>

                    @endauth

                    @endif
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @if (Route::has('login'))
                <a href="#home" class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Home</a>
                <a href="#persyaratan" class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Informasi</a>
                @auth
                <a href="{{ url('/dashboard') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Dashboard</a>

                @else
                <a href="{{ route('login') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-700">Masuk</a>


                @endauth


                @endif
            </div>
        </div>
    </nav>
    <!-- Slider Section -->
    <div class="relative w-full mt-16 overflow-hidden">
        <!-- Slider Container -->
        <div id="slider" class="flex transition-transform duration-700 ease-in-out">
            <!-- Slide 1 -->
            <div class="w-full flex-shrink-0">
                <img src="{{ asset('image/slide.png') }}" alt="Slide 1" class="w-full h-auto">
            </div>
            <!-- Slide 2 -->
            <div class="w-full flex-shrink-0">
                <img src="{{ asset('image/slide2.png') }}" alt="Slide 1" class="w-full h-auto">
            </div>
            <!-- Slide 3 -->
            <div class="w-full flex-shrink-0">
                <img src="{{ asset('image/slide.png') }}" alt="Slide 1" class="w-full h-auto">
            </div>
        </div>
        <!-- Navigation Buttons -->
        <button id="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2  text-white p-2 rounded-full shadow-md focus:outline-none">
            &larr;
        </button>
        <button id="next" class="absolute right-0 top-1/2 transform -translate-y-1/2  text-white p-2 rounded-full shadow-md focus:outline-none">
            &rarr;
        </button>
    </div>


    <!-- Content Section -->
    <section class="py-2 bg-gray-100" id="home">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-20">
            <div class=" grid grid-cols-1 md:grid-cols-1 gap-6 mb-4 mt-4">
                <div class="p-6 bg-white shadow rounded-lg">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang di YPW KALIMANTAN TIMUR</h2>
                    <p class="text-gray-600 mb-4">Sistem Pengelolaan Data Pengamal Sekalimantan Timur</p>
                    <!-- <a href="#persyaratan" class="text-blue-600 hover:underline">Lihat Persyaratan Pendaftaran</a> -->
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow rounded-lg">
                    <h3 class=" font-bold text-gray-800 mb-2">
                        <span class="text-xl">DEPARTEMEN PENYIARAN DAN PEMBINA WAHIDIYAH (DPPW)</span> <br>
                        <span></span>
                    </h3>
                    <p class="text-gray-600">Description of DEPARTEMEN PEMBINA.</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">DEPARTEMEN PEMBINA WANITA WAHIDIYAH (DPWW)</h3>
                    <p class="text-gray-600">Description of DEPARTEMEN PEMBINA.</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">DEPARTEMEN PEMBINA REMAJA WAHIDIYAH (DPRW)</h3>
                    <p class="text-gray-600">Description of DEPARTEMEN PEMBINA.</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">DEPARTEMEN PEMBINA KANAK-KANAK WAHIDIYAH (DPKW)</h3>
                    <p class="text-gray-600">Description of DEPARTEMEN PEMBINA.</p>
                </div>
                <!-- <div class="p-6 bg-white shadow rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">DEPARTEMEN PEMBINA KANAK KANAK WAHIDIYAH</h3>
                    <p class="text-gray-600">Description of DEPARTEMEN PEMBINA.</p>
                </div>
                <div class="p-6 bg-white shadow rounded-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">DEPARTEMEN PEMBINA</h3>
                    <p class="text-gray-600">Description of DEPARTEMEN PEMBINA.</p>
                </div> -->
            </div>
        </div>
    </section>
    <section id="profil" class="py-2 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-20 ">Profil</h2>
            <p class="text-gray-600 mb-6">Profil Yayasan</p>
            <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div style="text-align: justify;">



                </div>
                <div style="text-align: justify;">

                </div>

            </div>
        </div>
    </section>
    <section class="py-2 bg-gray-100" id="persyaratan">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-20 ">Informasi Seputar Pejuangan</h2>
            <p class="text-gray-600 mb-6">Informasi Seputar Pejuangan</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            </div>
        </div>
        </div>
    </section>
    <!-- Footer Section -->
    <footer class="bg-green-900 text-white py-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm">&copy; 2025 Your Company. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:underline">Privacy Policy</a>
                    <a href="#" class="hover:underline">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Slider functionality
        const slider = document.getElementById('slider');
        const slides = slider.children;
        const totalSlides = slides.length;
        let index = 0;

        // Function to update the slider position
        const updateSlider = () => {
            slider.style.transform = `translateX(-${index * 100}%)`;
        };

        // Manual navigation buttons
        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');

        prevButton.addEventListener('click', () => {
            index = (index === 0) ? totalSlides - 1 : index - 1;
            updateSlider();
            resetAutoSlide();
        });

        nextButton.addEventListener('click', () => {
            index = (index === totalSlides - 1) ? 0 : index + 1;
            updateSlider();
            resetAutoSlide();
        });

        // Auto-slide functionality
        let autoSlideInterval = setInterval(() => {
            index = (index === totalSlides - 1) ? 0 : index + 1;
            updateSlider();
        }, 5000); // Change slide every 5 seconds

        // Reset auto-slide interval when user interacts with navigation
        const resetAutoSlide = () => {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(() => {
                index = (index === totalSlides - 1) ? 0 : index + 1;
                updateSlider();
            }, 5000);
        };

        // Toggle mobile menu visibility
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>