{{-- Untuk menghubungkan file header yang ada di dalam folder backend_template --}}
@include('backend_template.header')

{{-- Untuk menghubungkan file navbar yang ada di dalam folder backend_template --}}
@include('backend_template.navbar')

{{-- Untuk menghubungkan dengan file sidebar yang ada di folder backend_template --}}
@include('backend_template.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('title-menu')</h1>
          </div>

          {{-- untuk membuat sebuah kontek yang nantinya terhubung dengan home atau view yg lain --}}
          @yield('content')
          
          <div class="section-body">
          </div>
        </section>
      </div>

{{-- Untuk menghubungkan dengan file footer yang ada di backend_template --}}
@include('backend_template.footer')