import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, User } from '@/types';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Table } from '@/components/ui/table';

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
    date:string,
    inBox:number | undefined
}
export default function Dashboard() {
    const a = usePage<{ products: Product[],sheft?:Sheft }>();
    console.log(a.props);
    const {data,setData,post} = useForm<SheftForm>({
        date:'',
        inBox:0

    });
    const onSubmit = (e)=>{
        e.preventDefault()
        post(route('sheft.store'))
    }

    // const
    return (
            <div className="flex h-screen justify-center items-center">
                <form onSubmit={onSubmit} className="">
                    <div className="flex gap-2 p-4" >
                        <div className="User">{'المستخدم'}</div>
                        <div className="User">{a.props.auth?.user?.name}</div>
                    </div>
                    <label className="p-2">{'التاريخ'}</label>
                    <input type={'date'}
                           className={'border p-2 rounded'}
                           value={data.date} onChange={(e)=>setData('date',e.target.value)}
                    />
                    <label className="p-2">{'الصندوق'}</label>
                        <input
                               value={data.inBox}
                               className={'border p-2 rounded'}
                               onChange={(e)=>setData('inBox',Number(e.target.value))}
                        />
                    <label className="p-2">{'ريال'}</label>

                    <div className="h-5"></div>
                    <div className="flex gap-2">

                    <Button>Confirm</Button>
                    <Button
                    variant={'outline'}
                    onClick={(e)=>{
                        e.preventDefault()
                        router.get('/dashboard')
                    }}
                    >Cancel</Button>
                    </div>

                </form>
            </div>
    );
}
