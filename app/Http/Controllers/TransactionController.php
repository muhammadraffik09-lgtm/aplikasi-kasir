<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Menampilkan halaman kasir (POS)
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.index', compact('products'));
    }

    // Memproses transaksi belanja
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'qty'        => 'required|array',
            'pay_amount' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            $detailsData = [];

            // Hitung total dan validasi stok
            foreach ($request->product_id as $index => $productId) {
                $qty = $request->qty[$index];
                if ($qty <= 0) continue;

                $product = Product::findOrFail($productId);
                
                if ($product->stock < $qty) {
                    return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi!");
                }

                $subtotal = $product->selling_price * $qty;
                $totalAmount += $subtotal;

                // Kurangi stok produk
                $product->stock -= $qty;
                $product->save();

                $detailsData[] = [
                    'product_id' => $productId,
                    'quantity'   => $qty,
                    'subtotal'   => $subtotal,
                ];
            }

            if ($request->pay_amount < $totalAmount) {
                return redirect()->back()->with('error', 'Uang pembayaran kurang dari total belanja!');
            }

            $changeAmount = $request->pay_amount - $totalAmount;
            $invoiceNumber = 'INV-' . strtoupper(uniqid());

            // Simpan ke tabel transactions
            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'total_amount'   => $totalAmount,
                'pay_amount'     => $request->pay_amount,
                'change_amount'  => $changeAmount,
            ]);

            // Simpan detail transaksi
            foreach ($detailsData as $detail) {
                $detail['transaction_id'] = $transaction->id;
                TransactionDetail::create($detail);
            }

            DB::commit();
            return redirect()->route('transactions.index')->with('success', "Transaksi Berhasil! Kembalian: Rp " . number_format($changeAmount, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}