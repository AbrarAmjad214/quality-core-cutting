{{--
    Master layout
    - partials/header.blade.php : <head> (meta, CSS, schema) + site header / navigation
    - page view                 : @section('content')
    - partials/footer.blade.php : site footer + all scripts

    Page views set:
      @section('title', '...')          <title> (≤ 60 characters)
      @section('description', '...')    meta description (≤ 155 characters)
      @section('og_image', asset(...))  optional social share image
      @push('schema') ... @endpush      extra JSON-LD for the page
--}}
@include('partials.header')

<main id="main">
    @yield('content')
</main>

@include('partials.footer')
