import React from "react";
import { Head, Link, usePage } from "@inertiajs/react";
import { router } from "@inertiajs/react";

export default function Index() {
    const { products } = usePage().props;

    const handleDelete = (id) => {
        if (confirm("Yakin ingin menghapus produk ini?")) {
            router.delete(`/products/${id}`);
        }
    };

    return (
        <div className="container mx-auto p-6">
            <Head title="Daftar Produk" />

            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Daftar Produk</h1>
                <Link
                    href="/products/create"
                    className="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Tambah Produk
                </Link>
            </div>

            <table className="w-full border-collapse">
                <thead>
                    <tr className="bg-gray-200">
                        <th className="border p-3 text-left">Nama</th>
                        <th className="border p-3 text-left">Harga</th>
                        <th className="border p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {products.data.map((product) => (
                        <tr key={product.id} className="hover:bg-gray-100">
                            <td className="border p-3">{product.name}</td>
                            <td className="border p-3">
                                Rp {product.price.toLocaleString("id-ID")}
                            </td>
                            <td className="border p-3 text-center">
                                <Link
                                    href={`/products/${product.id}/edit`}
                                    className="text-blue-500 mr-2"
                                >
                                    Edit
                                </Link>
                                <button
                                    onClick={() => handleDelete(product.id)}
                                    className="text-red-500"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
