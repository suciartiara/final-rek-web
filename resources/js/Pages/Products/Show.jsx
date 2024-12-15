import React from "react";
import { Head, Link, usePage } from "@inertiajs/react";

export default function Show() {
    const { product } = usePage().props; // Mengambil data produk dari props

    return (
        <div className="container mx-auto p-6">
            <Head title={`Detail Produk - ${product.name}`} />

            <div className="mb-6">
                <h1 className="text-3xl font-bold">{product.name}</h1>
                <p className="text-gray-600 text-sm">
                    {`Dibuat pada ${new Date(product.created_at).toLocaleDateString()}`}
                </p>
            </div>

            <div className="bg-white shadow-md rounded-lg p-6">
                <div className="mb-4">
                    <h2 className="text-xl font-semibold">Deskripsi</h2>
                    <p>{product.description}</p>
                </div>

                <div className="mb-4">
                    <h2 className="text-xl font-semibold">Harga</h2>
                    <p className="text-lg font-bold text-green-600">
                        Rp {product.price.toLocaleString("id-ID")}
                    </p>
                </div>

                <div className="flex justify-between items-center mt-6">
                    <Link
                        href="/products"
                        className="bg-gray-500 text-white px-4 py-2 rounded"
                    >
                        Kembali ke Daftar Produk
                    </Link>

                    <Link
                        href={`/products/${product.id}/edit`}
                        className="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        Edit Produk
                    </Link>
                </div>
            </div>
        </div>
    );
}
