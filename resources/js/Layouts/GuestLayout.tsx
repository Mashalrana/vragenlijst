import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <div
            className='min-h-screen bg-sky-50 relative'
            style={{ backgroundImage: "url('/img/background.jpg')", backgroundSize: 'cover' }}
        >
            <div
                className="flex flex-col sm:justify-center items-center min-h-screen z-10 absolute inset-0 px-4 sm:px-0 shadow-2xl"
            >
                <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {children}
                </div>
            </div>
            <div
                className="absolute inset-0 bg-black bg-opacity-60 z-0 backdrop-blur-sm"
            ></div>
        </div>
    );
}

