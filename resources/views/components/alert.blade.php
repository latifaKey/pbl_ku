@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> Terdapat kesalahan pada input:
        <ul class="mt-2 mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<script>
// Aktifkan SweetAlert2 notifikasi jika ada flash messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        window.showNotification('Berhasil!', "{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        window.showNotification('Error!', "{{ session('error') }}", 'error');
    @endif

    @if(session('warning'))
        window.showNotification('Perhatian!', "{{ session('warning') }}", 'warning');
    @endif

    @if(session('info'))
        window.showNotification('Informasi', "{{ session('info') }}", 'info');
    @endif

    @if($errors->any())
        window.showNotification(
            'Error Input!',
            "Terdapat {{ $errors->count() }} kesalahan pada input. Silahkan periksa form.",
            'error'
        );
    @endif
});
</script>
