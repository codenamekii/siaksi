{{-- resources/views/layouts/asesor.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') - SIAKSI Asesor</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Alpine.js for interactivity -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Additional Styles -->
  <style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, #2563eb 0%, #4f46e5 100%);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, #1d4ed8 0%, #4338ca 100%);
    }

    /* Smooth scroll behavior */
    html {
      scroll-behavior: smooth;
    }

    /* Loading animation */
    .loader {
      border-top-color: #3b82f6;
      -webkit-animation: spinner 1.5s linear infinite;
      animation: spinner 1.5s linear infinite;
    }

    @-webkit-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
      }

      100% {
        -webkit-transform: rotate(360deg);
      }
    }

    @keyframes spinner {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* Page transition */
    .page-enter {
      opacity: 0;
      transform: translateY(10px);
    }

    .page-enter-active {
      transition: all 0.3s ease-out;
    }

    .page-enter-to {
      opacity: 1;
      transform: translateY(0);
    }
  </style>

  @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
  <div class="min-h-screen flex flex-col">
    {{-- Navbar Component --}}
    <x-asesor.navbar />

    {{-- Main Content with padding for fixed navbar --}}
    <main class="flex-1 pt-16 page-enter page-enter-active page-enter-to">
      {{-- Breadcrumb Section --}}
      @hasSection('breadcrumb')
        <div class="bg-white shadow-sm border-b border-gray-200">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-3">
              @yield('breadcrumb')
            </div>
          </div>
        </div>
      @endif

      {{-- Page Header --}}
      @hasSection('header')
        <header class="bg-white shadow-sm">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @yield('header')
          </div>
        </header>
      @endif

      {{-- Flash Messages --}}
      @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform translate-y-2"
          x-transition:enter-end="opacity-100 transform translate-y-0"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform translate-y-0"
          x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed top-20 right-4 z-50">
          <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-lg">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
              </div>
              <div class="ml-auto pl-3">
                <button @click="show = false" class="text-green-400 hover:text-green-600">
                  <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      @endif

      @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform translate-y-2"
          x-transition:enter-end="opacity-100 transform translate-y-0"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform translate-y-0"
          x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed top-20 right-4 z-50">
          <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-lg">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
              </div>
              <div class="ml-auto pl-3">
                <button @click="show = false" class="text-red-400 hover:text-red-600">
                  <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      @endif

      {{-- Main Content Area --}}
      <div class="flex-1">
        @yield('content')
      </div>
    </main>

    {{-- Footer Component --}}
    <x-asesor.footer />

    {{-- Return to Original Dashboard Button --}}
    @include('components.return-to-original-button')
  </div>

  {{-- Loading Overlay --}}
  <div id="loading-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[100] flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 flex flex-col items-center">
      <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
      <p class="text-gray-700 font-semibold">Loading...</p>
    </div>
  </div>

  {{-- Global Scripts --}}
  <script>
    // Show loading overlay for AJAX requests
    document.addEventListener('DOMContentLoaded', function() {
      // Add loading state to all forms
      const forms = document.querySelectorAll('form');
      forms.forEach(form => {
        form.addEventListener('submit', function() {
          if (!form.classList.contains('no-loading')) {
            document.getElementById('loading-overlay').classList.remove('hidden');
          }
        });
      });

      // Add loading state to specific links
      const loadingLinks = document.querySelectorAll('a.with-loading');
      loadingLinks.forEach(link => {
        link.addEventListener('click', function() {
          document.getElementById('loading-overlay').classList.remove('hidden');
        });
      });
    });

    // Hide loading overlay when page is fully loaded
    window.addEventListener('load', function() {
      document.getElementById('loading-overlay').classList.add('hidden');
    });

    // Prevent multiple form submissions
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        const submitButton = form.querySelector('[type="submit"]');
        if (submitButton && !submitButton.disabled) {
          submitButton.disabled = true;
          submitButton.innerHTML =
            '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
        }
      });
    });
  </script>

  @stack('scripts')
</body>

</html>
