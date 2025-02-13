<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-3xl mx-auto bg-white p-5 rounded shadow">
        <h2 class="text-2xl font-bold mb-4 text-center">To-Do List</h2>

        <!-- Form Tambah Tugas -->
        <form action="{{ route('todos.store') }}" method="POST" class="mb-4 flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Tambah tugas" class="border p-2 w-full rounded" required>
            <select name="prioritas" class="border p-2 rounded" required>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Tambah</button>
        </form>

        <!-- Tabel Daftar To-Do -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 text-center">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">#</th>
                        <th class="border border-gray-300 px-4 py-2">Tugas</th>
                        <th class="border border-gray-300 px-4 py-2">Prioritas</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal Dicentang</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todos as $index => $todo)
                        <tr class="{{ $todo->status ? 'bg-green-100' : '' }}">
                            <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2 {{ $todo->status ? 'line-through text-gray-500' : '' }}">
                                {{ $todo->name }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-yellow-500">
                                {{ str_repeat('⭐', $todo->prioritas) }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <form action="{{ route('todos.toggle', $todo->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-lg">
                                        @if ($todo->status)
                                            ✅ Selesai
                                        @else
                                            ⬜ Belum
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $todo->tanggal_diceklis ? $todo->tanggal_diceklis->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 flex gap-2 justify-center">
                                <button onclick="editTodo({{ $todo }})" class="text-blue-500 text-lg">✏️</button>
                                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-lg">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($todos->isEmpty())
            <p class="text-center text-gray-500 mt-4">Belum ada tugas.</p>
        @endif  
    </div>

    <!-- Modal Edit -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-5 rounded shadow w-96 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-lg">
            ❌
        </button>

        <h3 class="text-xl font-bold mb-3 text-center">Edit To-Do</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PATCH')

            <!-- Input Nama -->
            <input type="text" name="name" id="editName" class="border p-2 w-full rounded mb-2" required>

            <!-- Pilihan Prioritas -->
            <select name="prioritas" id="editPrioritas" class="border p-2 w-full rounded mb-4" required>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>

            <!-- Tombol Simpan -->
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Simpan</button>
        </form>
    </div>
</div>

<script>
    function editTodo(todo) {
        document.getElementById('editForm').action = `/todos/${todo.id}`;
        document.getElementById('editName').value = todo.name;
        document.getElementById('editPrioritas').value = todo.prioritas;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Menutup modal jika pengguna mengklik di luar form
    document.getElementById('editModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });
</script>

</body>
</html>
