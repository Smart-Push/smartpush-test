export interface TrunkedTransaction {
    id: number;
    label: string;
}

export interface DetailedTransaction {
    id: number;
    label: string;
    amount: string;
    type_payment_id: number;
}

export interface PaymentType {
    id: number;
    name: string;
}
