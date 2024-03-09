
@if ($status == 'error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{$message}}
        
    </div>
@else
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{$message}}
        
    </div>
    
@endif