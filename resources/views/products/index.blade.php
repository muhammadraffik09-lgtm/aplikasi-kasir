<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir - Kelola Produk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            color: #0d6efd !important;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .btn-primary {
            border-radius: 8px;
            font-weight: 600;
        }
        .table thead {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-cash-register me-2"></i>POS Kasir</a>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-primary active"><i class="fa-solid fa-box me-1"></i> Produk</a>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-cart-shopping me-1"></i> Transaksi Kasir</a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Form Tambah Produk -->
            <div class="col-md-4">
                <div class="card p-3">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-plus-circle text-primary me-2"></i>Tambah Produk</h5>
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Produk</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Kopi Susu" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Harga Beli (Modal)</label>
                            <input type="number" name="purchase_price" class="form-control" placeholder="10000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Harga Jual</label>
                            <input type="number" name="selling_price" class="form-control" placeholder="15000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok Barang</label>
                            <input type="number" name="stock" class="form-control" placeholder="50" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-save me-1"></i> Simpan Produk</button>
                    </form>
                </div>
            </div>

            <!-- Daftar Produk -->
            <div class="col-md-8">
                <div class="card p-3">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-list text-primary me-2"></i>Daftar Stok Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Produk</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $product->name }}</td>
                                        <td>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                        <td class="text-success fw-bold">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $product->stock > 5 ? 'bg-info' : 'bg-danger' }}">
                                                {{ $product->stock }} Pcs
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada produk. Tambahkan produk pertama kamu!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>