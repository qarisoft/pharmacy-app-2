import { Table, TableBody, TableCell, TableFooter, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useLang } from '@/hooks/useLang';
import { Product, SaleHeader, SaleItem } from '@/types';
import AppLayout from '@/layouts/app-layout';
import AppearanceTabs from '@/components/appearance-tabs';
import { Head } from '@inertiajs/react';
import { B } from '../../../../bootstrap/ssr/assets/app-logo-icon-Ob1cKZaq';
import { Button } from '@/components/ui/button';
import { useRef } from 'react';

type ShowProps = { row: SaleHeader & { id: number; items: SaleItem[] } };

const getUnitCost = (unit_id:number, p: Product) => {
    const u = p.units.find((i) => i.id == unit_id);
    if (!u) return 0;
    return u.count * p.unit_price - (u.discount ?? 0);
};

function TableComponent({ row }: ShowProps) {
    const { __ } = useLang();
    const items = row.items;

    return (
        <Table className={''}>
            {/*<TableCaption>A list of your recent invoices.</TableCaption>*/}
            <TableHeader>
                <TableRow>
                    <TableHead className="w-[100px]">{__('product')}</TableHead>
                    <TableHead>{__('quantity')}</TableHead>
                    <TableHead>{__('unit price')}</TableHead>
                    <TableHead>{__('total price')}</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody >
                {items.map((itm) => (
                    <TableRow key={itm.id} className={'h-fit'}>
                        <TableCell className=" min-w-[40vw]">{itm.product.name_ar}</TableCell>
                        <TableCell className="">{itm.quantity}</TableCell>
                        <TableCell className="">{getUnitCost(itm.unit_id, itm.product)}</TableCell>
                        <TableCell className="">{itm.end_price}</TableCell>
                    </TableRow>
                ))}
                <TableRow>
                    <TableCell></TableCell>
                </TableRow>
            </TableBody>

        </Table>
    );
}
import { usePDF, useReactToPdf } from 'react-to-pdf';
export default function ({ row }: ShowProps) {
    console.log(row);
    const { __ } = useLang();
    // const pageRef = useRef(null)
    // const today = row.created_at;
    const today = new Date(`${row.created_at}`).toLocaleDateString('ar');
    return (
        <div>
            <div

                className={'p-4 h-screen  flex justify-center '}>
                <div className="absolute right-0 opacity-0 hover:opacity-90">

                    <AppearanceTabs />
                </div>
                <div
                    className="rounded border p-4 h-full overflow-y-auto flex flex-col ">
                    <div className="mb-5 flex justify-between px-2">
                        <div className="flex-1">
                            <div className="">{'صيدلية المحيا'}</div>
                            <div className="">{'للادوية والمستلزمات الطبية'}</div>
                            <div className="">{'شارع الزراعة - حي الكويت'}</div>
                            <div className="">
                                <span className="">{'777357884'}</span>
                                <span> - </span>
                                <span className="">{'733495100'}</span>
                            </div>
                        </div>
                        <div className="flex-1">
                            {/*<div className="text-center">Al-mohia Pharmacy</div>*/}
                            <div className="text-center font-bold">{__('صيدلية المحيا')}</div>
                        </div>
                        <div className="flex-1">
                            <div className="">Al-mohaia Pharma</div>
                            <div className="">Outstanding medical service</div>
                            <div className="">
                                <span className="">{'777357884'}</span>
                                <span> - </span>
                                <span className="">{'733495100'}</span>
                            </div>
                        </div>
                    </div>
                    <div className="">
                        <div
                            style={{backgroundColor:'#d1d5dc'}}
                            className=" mb-4 border p-1 print:bg-muted text-center">{'قاتورة بيع نقدا'}</div>

                        <div className="flex justify-between px-2">
                            <div className="flex flex-1">

                                <div className="p-1">{'اسم العميل'}</div>
                                <div className="px-1"> : </div>
                                <div className="border-b border-dotted p-1 flex-1">{row.customer_name}</div>
                            </div>
                            <div className="w-10"></div>

                            <div className="">
                            <span>
                                {'التاريخ'}
                                <span className={'px-1'}>:</span>
                            </span>
                                <span>{today}</span>
                            </div>
                        </div>
                    </div>
                    <div className="h-10"></div>
                    <div className="rounded border p-2 flex-1 flex flex-col justify-between">
                        <TableComponent row={row} />
                        <Table>
                            <TableFooter className={'pt-5'}>
                                <TableRow className={'pt-5'}>
                                    <TableCell colSpan={1}>{'الخصم'}</TableCell>
                                    <TableCell className="text-right">{row.discount}</TableCell>
                                    <TableCell  className="w-[70vw]"></TableCell>

                                </TableRow>
                                <TableRow>
                                    <TableCell colSpan={1}>{'السعر النهائي'}</TableCell>
                                    <TableCell className="text-right">{row.end_price}</TableCell>
                                    <TableCell className="w-[70vw]"></TableCell>


                                </TableRow>
                            </TableFooter>
                        </Table>
                    </div>
                </div>
            </div>

        </div>


    );
}
