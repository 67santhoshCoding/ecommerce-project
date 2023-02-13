<div class="page-header">
    <h3 class="page-title"> {{ $title ?? '' }} </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @isset($breadCrum)
        @foreach ($breadCrum as $item )
            <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
        @endforeach 
        @endisset
        
      </ol>
    </nav>
  </div>