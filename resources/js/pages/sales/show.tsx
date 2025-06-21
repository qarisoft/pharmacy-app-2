import { Table, TableBody, TableCell, TableFooter, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useLang } from '@/hooks/useLang';
import { Product, SaleHeader, SaleItem } from '@/types';

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
                    <TableRow key={itm.id}>
                        <TableCell className="p-4">{itm.product.name_ar}</TableCell>
                        <TableCell className="p-4">{getUnitCost(itm.unit_id, itm.product)}</TableCell>
                        <TableCell className="p-4">{itm.quantity}</TableCell>
                        <TableCell className="p-4">{itm.end_price}</TableCell>
                    </TableRow>
                ))}
            </TableBody>

        </Table>
    );
}

export default function ({ row }: ShowProps) {
    console.log(row);
    const { __ } = useLang();
    // const today = row.created_at;
    const today = new Date(`${row.created_at}`).toLocaleDateString('ar');
    return (
        <div className={'p-4 h-screen'}>
            <div className="rounded border p-4 h-full flex flex-col">
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
                        <div className="text-center">Al-mohia Pharmacy</div>
                        <div className="text-center">{__('bill')}</div>
                    </div>
                    <div className="flex-1"></div>
                </div>
                <div className="">
                    <div className=" mb-4 bg-muted p-1 text-center">{'قاتورة بيع نقدا'}</div>

                    <div className="flex justify-between px-2">
                        <div className="">{'اسم العميل'}</div>

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
    );
}
