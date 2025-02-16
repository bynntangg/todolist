<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
        }
    </style>
</head>

<body class="p-4 bg-white">
    <div class="container bg-white p-4 rounded shadow">
        <h1 class="mb-5 text-center fw-bold">To-Do List</h1>
        <form action="{{ route('todos.store') }}" method="POST" class="d-flex gap-2 mb-4">
            @csrf
            <input type="text" name="name" class="form-control" placeholder="Tambah tugas" required>
            <select name="prioritas" class="form-select" required>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
        </form>

        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tugas</th>
                    <th>Prioritas</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Aksi</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todos as $index => $todo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="{{ $todo->status ? 'text-decoration-line-through text-muted' : '' }}">
                            {{ $todo->name }}</td>
                        <td>
                            <span class="badge rounded-pill text-dark @if($todo->prioritas == 'Rendah') bg-success-subtle @elseif($todo->prioritas == 'Sedang') bg-warning-subtle @elseif($todo->prioritas == 'Tinggi') bg-danger-subtle @endif">
                                {{ $todo->prioritas }}
                            </span>
                        </td>
                        <td>{{ $todo->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <form action="{{ route('todos.toggle', $todo->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="badge rounded-pill bg-primary border-0"><i class="bi bi-check-circle"></i></button>
                            </form>
                            @if (!$todo->status)
                                <button type="button" class="badge rounded-pill bg-warning border-0 text-dark d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $todo->id }}">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </button>
                            @endif
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="badge rounded-pill bg-danger border-0 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </form>
                            
                        </td>
                        <td>{{ $todo->status ? $todo->tanggal_diceklis->format('d M Y H:i') : 'Belum Selesai' }}</td>
                    </tr>

                    @if (!$todo->status)
                        <div class="modal fade" id="editModal{{ $todo->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Tugas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div class="modal-body">
                                            <input type="text" name="name" class="form-control mb-2" value="{{ $todo->name }}" required>
                                            <select name="prioritas" class="form-select" required>
                                                <option value="Rendah" {{ $todo->prioritas == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                                <option value="Sedang" {{ $todo->prioritas == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                                <option value="Tinggi" {{ $todo->prioritas == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
