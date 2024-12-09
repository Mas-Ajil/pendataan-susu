<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    
      
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        @include('partials.sidebar')
    </div>

</body>
</html>

<section class="custom-home">
    <div class="container">
        @yield('content')
    </div>
</section>