<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir - POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class="fa-solid fa-cash-register me-2"></i>POS Kasir</a>
            <div class="d-flex gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-box me-1"></i> Produk</a>
                <a href="{{ route('transactions.index') }}" class="btn btn-primary active"><i class="fa-solid fa-cart-shopping me-1"></i> Transaksi Kasir</a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Daftar Produk Tersedia -->
                <div class="col-md-7">
                    <div class="card p-3">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-boxes-stacked text-primary me-2"></i>Pilih Produk</h5>
                        <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                            <table class="table table-hover align-middle">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Beli (Qty)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td class="fw-semibold">{{ $product->name }}</td>
                                            <td class="text-success">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                            <td><span class="badge bg-info">{{ $product->stock }}</span></td>
                                            <td style="width: 120px;">
                                                <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                                <input type="number" name="qty[]" class="form-control form-control-sm" value="0" min="0" max="{{ $product->stock }}">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Stok produk kosong atau belum ditambahkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bagian Pembayaran / Checkout -->
                <div class="col-md-5">
                    <div class="card p-4 bg-white">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-receipt text-primary me-2"></i>Ringkasan Pembayaran</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Total Uang Bayar (Rp)</label>
                            <input type="number" name="pay_amount" class="form-control form-control-lg" placeholder="Masukkan jumlah uang..." required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            <i class="fa-solid fa-check-circle me-1"></i> Proses Transaksi & Bayar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>