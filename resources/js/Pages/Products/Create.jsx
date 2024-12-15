import React from "react";
import { Head, useForm, Link } from "@inertiajs/react";

export default function Create() {
    const { data, setData, post, errors, processing } = useForm({
        name: "",
        description: "",
        price: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/products", {
            preserveScroll: true,
        });
    };

    return (
        <div className="container mx-auto p-6">
            <Head title="Tambah Produk Baru" />

            <div className="max-w-md mx-auto bg-white p-6 rounded shadow">
                <h1 className="text-2xl font-bold mb-6">Tambah Produk Baru</h1>

                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label className="block mb-2">Nama Produk</label>
                        <input
                            type="text"
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                            className="w-full px-3 py-2 border rounded"
                        />
                        {errors.name && (
                            <div className="text-red-500 text-sm mt-1">
                                {errors.name}
                            </div>
                        )}
                    </div>

                    <div className="mb-4">
                        <label className="block mb-2">Deskripsi</label>
                        <textarea
                            value={data.description}
                            onChange={(e) =>
                                setData("description", e.target.value)
                            }
                            className="w-full px-3 py-2 border rounded"
                        />
                        {errors.description && (
                            <div className="text-red-500 text-sm mt-1">
                                {errors.description}
                            </div>
                        )}
                    </div>

                    <div className="mb-4">
                        <label className="block mb-2">Harga</label>
                        <input
                            type="number"
                            value={data.price}
                            onChange={(e) => setData("price", e.target.value)}
                            className="w-full px-3 py-2 border rounded"
                        />
                        {errors.price && (
                            <div className="text-red-500 text-sm mt-1">
                                {errors.price}
                            </div>
                        )}
                    </div>

                    <div className="flex justify-between">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-blue-500 text-white px-4 py-2 rounded"
                        >
                            {processing ? "Menyimpan..." : "Simpan"}
                        </button>
                        <Link
                            href="/products"
                            className="text-gray-500 hover:underline"
                        >
                            Batal
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    );
}
