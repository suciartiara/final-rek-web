import React, { useState, useEffect } from 'react';

const ToastNotification = ({ message, type = 'success', duration = 3000 }) => {
    const [visible, setVisible] = useState(true);

    useEffect(() => {
        const timer = setTimeout(() => {
            setVisible(false);
        }, duration);

        return () => clearTimeout(timer);
    }, [duration]);

    if (!visible) return null;

    const typeStyles = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };

    return (
        <div className={`fixed top-4 right-4 ${typeStyles[type]} text-white px-6 py-4 rounded shadow-lg z-50`}>
            {message}
        </div>
    );
};

export default ToastNotification;