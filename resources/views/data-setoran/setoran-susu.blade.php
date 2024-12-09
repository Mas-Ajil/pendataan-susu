@extends('partials.sidebar')

@section('content')

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Setoran Susu</h4>
        <div>
            <form action="{{ route('setoran.index') }}" method="GET" class="d-flex align-items-center">
                <input type="text" name="search" id="search" class="form-control form-control-sm me-2" 
                       placeholder="Cari nama peternak..." value="{{ request('search') }}" style="width: 200px;">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <!-- Button trigger modal for adding -->
            <button class="btn btn-sm btn-success ms-2" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus"></i>
            </button>
        </div>
    </div>
    <table class="table table-borderless align-middle">
        <thead class="table-light">
            <tr>
            
                <th>Nama Peternak</th>
                <th>Nomor Daerah</th>
                <th>Pagi</th>
                <th>Sore</th>
                <th>Jumlah Setoran</th>
                <th>Tanggal Setoran</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($setoran as $setorans)
            <tr>
                <td>{{ $setorans->peternak->nama_peternak }}</td>
                <td>{{ $setorans->peternak->no_daerah }}</td>
                <td>{{ $setorans->jumlah_pagi }}</td>
                <td>{{ $setorans->jumlah_sore }}</td>
                <td>Rp {{ number_format($setorans->jumlah_setoran, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($setorans->tanggal_setoran)->format('d-m-Y') }}</td>

            </tr>

            @endforeach
        </tbody>
    </table>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $setoran->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('setoran.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Data Setoran Susu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_peternak" class="form-label">Nama Peternak</label>
                        <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" placeholder="Ketik nama peternak..." autocomplete="off" required>
                        <div class="list-group" id="suggestions" style="position: absolute; z-index: 1050;"></div>
                    </div>
                    <input type="hidden" id="peternak_id" name="peternak_id">
                    <div class="mb-3">
                        <label for="no_daerah" class="form-label">Nomor Daerah</label>
                        <input type="text" class="form-control" id="no_daerah" name="no_daerah" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_setoran" class="form-label">Tanggal Setoran</label>
                        <input type="date" class="form-control" id="tanggal_setoran" name="tanggal_setoran" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="setoran_pagi" class="form-label">Setoran Pagi (Liter)</label>
                        <input type="number" class="form-control" id="setoran_pagi" name="setoran_pagi" required>
                    </div>
                    <div class="mb-3">
                        <label for="setoran_sore" class="form-label">Setoran Sore (Liter)</label>
                        <input type="number" class="form-control" id="setoran_sore" name="setoran_sore" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_setoran" class="form-label">Jumlah Setoran (Rp)</label>
                        <input type="text" class="form-control" id="jumlah_setoran" name="jumlah_setoran" readonly>
                    </div>

                </div>
                
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('input', function () {
        const pagi = parseFloat(document.getElementById('setoran_pagi').value) || 0;
        const sore = parseFloat(document.getElementById('setoran_sore').value) || 0;
        const total = (pagi + sore) * 7600;
        document.getElementById('jumlah_setoran').value = total.toLocaleString('id-ID');
    });
</script>



<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    document.getElementById('nama_peternak').addEventListener('input', function () {
        const query = this.value;
        if (query.length >= 2) { // Mulai cari jika panjang input >= 2 karakter
            fetch(`/search-peternak?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const suggestions = document.getElementById('suggestions');
                    suggestions.innerHTML = ''; // Kosongkan saran sebelumnya
                    data.forEach(item => {
                        const option = document.createElement('button');
                        option.type = 'button';
                        option.classList.add('list-group-item', 'list-group-item-action');
                        option.textContent = `${item.nama_peternak} (${item.no_daerah})`;
                        option.dataset.id = item.id;
                        option.dataset.nama = item.nama_peternak;
                        option.dataset.no_daerah = item.no_daerah;
                        option.addEventListener('click', function () {
                            document.getElementById('nama_peternak').value = item.nama_peternak;
                            document.getElementById('peternak_id').value = item.id;
                            document.getElementById('no_daerah').value = item.no_daerah;
                            suggestions.innerHTML = ''; // Bersihkan daftar setelah memilih
                        });
                        suggestions.appendChild(option);
                    });
                });
        }
    });

    // Hapus daftar saran jika input kehilangan fokus
    document.getElementById('nama_peternak').addEventListener('blur', function () {
        setTimeout(() => document.getElementById('suggestions').innerHTML = '', 200);
    });
</script>





@endsection
