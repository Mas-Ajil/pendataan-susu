@extends('partials.sidebar')

@section('content')

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Data Peternak</h4>
        <div>
            <label for="sort" class="me-2">Sort by:</label>
            <select id="sort" class="form-select form-select-sm" style="width: auto;">
                <option selected>Newest</option>
                <option>Oldest</option>
            </select>
            <!-- Button trigger modal for adding -->
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus"></i>
            </button>
        </div>
    </div>
    <table class="table table-borderless align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Peternak</th>
                <th>Nomor Daerah</th>
                <th>Simpanan</th>
                <th>Waktu Mulai</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peternak as $peternaks)
            <tr>
                <td>{{ $peternaks->nama_peternak }}</td>
                <td>{{ $peternaks->no_daerah }}</td>
                <td>{{ $peternaks->simpan_pinjam }}</td>
                <td>{{ $peternaks->created_at }}</td>
                <td class="text-end">
                    <!-- Button trigger modal for editing -->
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $peternaks->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('peternak.destroy', $peternaks->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $peternaks->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('peternak.update', $peternaks->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Data Peternak</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_peternak" class="form-label">Nama Peternak</label>
                                    <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" value="{{ $peternaks->nama_peternak }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_daerah" class="form-label">Nomor Daerah</label>
                                    <input type="text" class="form-control" id="no_daerah" name="no_daerah" value="{{ $peternaks->no_daerah }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="simpan_pinjam" class="form-label">Simpanan</label>
                                    <input type="number" class="form-control" id="simpan_pinjam" name="simpan_pinjam" value="{{ $peternaks->simpan_pinjam }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('peternak.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Peternak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_peternak" class="form-label">Nama Peternak</label>
                        <input type="text" class="form-control" id="nama_peternak" name="nama_peternak" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_daerah" class="form-label">Nomor Daerah</label>
                        <input type="text" class="form-control" id="no_daerah" name="no_daerah" required>
                    </div>
                    <div class="mb-3">
                        <label for="simpan_pinjam" class="form-label">Simpanan</label>
                        <input type="number" class="form-control" id="simpan_pinjam" name="simpan_pinjam" required>
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

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@endsection
