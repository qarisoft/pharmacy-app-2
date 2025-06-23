import { Breadcrumbs } from '@/components/breadcrumbs';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { type BreadcrumbItem as BreadcrumbItemType, Sheft } from '@/types';
import { router, usePage } from '@inertiajs/react';
import { Plus, RefreshCcw } from 'lucide-react';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';

export function AppSidebarHeader({ breadcrumbs = [] }: { breadcrumbs?: BreadcrumbItemType[] }) {
    const {props:{sheft}}= usePage<{sheft:Sheft}>()

    console.log(sheft);
    return (
        <header className="flex h-16 shrink-0 items-center justify-between gap-2 border-b border-sidebar-border/50 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
            <div className="flex items-center gap-2">
                <SidebarTrigger className="-ms-1" />
                <Breadcrumbs breadcrumbs={breadcrumbs} />
            </div>
            <div className="flex gap-2">

                <div className="">{sheft.user?.name}</div>
                <div className="">{sheft.date}</div>
                <div
                    className="hover:cursor-pointer"
                    onClick={() => {
                        router.post(route('products.pull'));
                    }}
                >
                    <RefreshCcw />
                </div>
            </div>
        </header>
    );
}
