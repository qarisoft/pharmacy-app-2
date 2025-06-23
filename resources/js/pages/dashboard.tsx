import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, User } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { route } from 'ziggy-js';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
type Product = {
    id: number;
    name_ar: string;
    barcode: string;
    name_en: string;
};
type SalePointForm = {
    header: {
        customer_name: string;
        total_price: string;
        discount: number;
        addition: number;
    };
    items: { product_id: number; unit_id: number }[];
};
type Sheft={
    id:number,
    user:User,
    date:string
}

type SheftForm={
    date:string
}
export default function Dashboard() {
    const a = usePage<{ products: Product[],sheft?:Sheft }>();
    console.log(a.props);
    const {data,setData} = useForm<SheftForm>({
        date:new Date().getDate().toString()
    });
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="w-fit">

                <Button
                    variant={'link'}
                    onClick={()=>router.get(route('sheft'))}
                >{'شفت جديد'}</Button>
                </div>

            </div>
        </AppLayout>
    );
}
