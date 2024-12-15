import React from "react";

const ValidatedInput = ({
    label,
    type = "text",
    value,
    onChange,
    error,
    placeholder = "",
    ...props
}) => {
    return (
        <div className="mb-4">
            {label && (
                <label className="block text-gray-700 text-sm font-bold mb-2">
                    {label}
                </label>
            )}
            <input
                type={type}
                value={value}
                onChange={onChange}
                placeholder={placeholder}
                className={`
                    w-full px-3 py-2 border rounded
                    ${error ? "border-red-500" : "border-gray-300"}
                    focus:outline-none focus:ring-2 
                    ${error ? "focus:ring-red-400" : "focus:ring-blue-400"}
                `}
                {...props}
            />
            {error && (
                <p className="text-red-500 text-xs italic mt-1">{error}</p>
            )}
        </div>
    );
};

export default ValidatedInput;
