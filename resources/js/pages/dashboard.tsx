import React, { useEffect } from 'react';
import { router, usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';

export default function Dashboard() {
    const { auth } = usePage<SharedData>().props;
    
    useEffect(() => {
        // This component should not be rendered since DashboardController
        // redirects to the appropriate dashboard. If we reach here, 
        // redirect to login as fallback.
        if (!auth.user) {
            router.visit('/login');
        }
    }, [auth.user]);

    return (
        <div className="flex min-h-screen items-center justify-center">
            <div className="text-center">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                <p className="mt-4 text-gray-600">Loading dashboard...</p>
            </div>
        </div>
    );
}