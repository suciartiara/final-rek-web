import React from "react";
import { Link } from "@inertiajs/react";

const Pagination = ({ links, onPageChange }) => {
    return (
        <div className="flex justify-center space-x-2 mt-4">
            {links.map((link, index) => (
                <Link
                    key={index}
                    href={link.url}
                    onClick={(e) => {
                        if (onPageChange && link.url) {
                            e.preventDefault();
                            onPageChange(link.url);
                        }
                    }}
                    className={`
                        px-4 py-2 rounded
                        ${
                            link.active
                                ? "bg-blue-500 text-white"
                                : "bg-gray-200"
                        }
                        ${
                            link.url
                                ? "hover:bg-blue-600"
                                : "cursor-not-allowed opacity-50"
                        }
                    `}
                    preserveState
                    preserveScroll
                >
                    {link.label.replace("&laquo;", "←").replace("&raquo;", "→")}
                </Link>
            ))}
        </div>
    );
};

export default Pagination;
