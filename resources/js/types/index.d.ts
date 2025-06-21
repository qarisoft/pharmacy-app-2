import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface NavItemGroup {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
    items: NavSubItem[];
}

export interface NavSubItem {
    title: string;
    href: string;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;

    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;

    [key: string]: unknown; // This allows for additional properties...
}

export interface PaginatedData<T> {
    current_page: number;
    data: T[];
    from: number;
    last_page: number;
    first_page_url: string;
    last_page_url: string;
    path: string;
    links: Link[];
    next_page_url: string | null;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export type ToolBarOptions = {
    onCreate?: () => void;
};

export type Unit = {
    id: number;
    name: string;
    count: number;
    discount: number;
};
export type Product = {
    id: number;
    name_ar: string;
    barcode: string;
    barcode2: string;
    code: number;
    name_en: string;
    units: Unit[];
    unit_price: number;
};

export type SaleHeader = {
    customer_name: string;
    note: string;
    end_price: number;
    discount: number;
    addition: number;
    id?: number;
    created_at?:string
};
export type SaleItem = {
    id?: number;
    product_id: number;
    unit_id: number;
    quantity: number;
    end_price: number;
    product: Product;
};
export type SalePointForm = {
    header: SaleHeader;
    items: SaleItem[];
};
