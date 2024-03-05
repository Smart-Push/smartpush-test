import axios from "axios";

export interface Transaction {
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
  name: string;
}


export const mockTransactions: Transaction[] = [
  {
    id: 1,
    label: "withdrawal transaction at Morissette - Pagac using card ending with ***(...3987) for AED 256.40 in account ***19329752",
  },
  {
    id: 2,
    label: "deposit transaction at Smitham - Turner using card ending with ***(...7327) for RWF 662.59 in account ***11435570",
  },
  {
    id: 3,
    label: "withdrawal transaction at Leuschke Group using card ending with ***(...4818) for TND 234.94 in account ***56144192",
  },
  {
    id: 4,
    label: "withdrawal transaction at Renner, Bechtelar and Howe using card ending with ***(...1602) for AOA 517.23 in account ***23232761",
  },
  {
    id: 5,
    label: "deposit transaction at Braun and Sons using card ending with ***(...4900) for PKR 121.36 in account ***68959559",
  },
  {
    id: 6,
    label: "withdrawal transaction at Cremin - Fritsch using card ending with ***(...4142) for MYR 182.94 in account ***05865398",
  },
  {
    id: 7,
    label: "payment transaction at Hauck - Stanton using card ending with ***(...6107) for LVL 621.72 in account ***53133577",
  },
  {
    id: 8,
    label: "deposit transaction at Roob, Jerde and Hermiston using card ending with ***(...2501) for SRD 453.84 in account ***56674653",
  },
  {
    id: 9,
    label: "withdrawal transaction at Cole and Sons using card ending with ***(...6094) for SRD 610.21 in account ***53471715",
  },
  {
    id: 10,
    label: "payment transaction at Harris, Bradtke and Rath using card ending with ***(...3636) for CDF 5.39 in account ***87806876",
  },
  {
    id: 11,
    label: "invoice transaction at Smith Inc using card ending with ***(...0936) for MGA 698.27 in account ***14420609",
  },
  {
    id: 12,
    label: "withdrawal transaction at Cremin Inc using card ending with ***(...5252) for KRW 357.15 in account ***75822244",
  },
  {
    id: 13,
    label: "invoice transaction at McKenzie and Sons using card ending with ***(...1334) for AMD 951.77 in account ***65404225",
  },
  {
    id: 14,
    label: "payment transaction at Christiansen Inc using card ending with ***(...4569) for EEK 387.69 in account ***15681361",
  },
  {
    id: 15,
    label: "payment transaction at Grady LLC using card ending with ***(...7919) for AMD 758.92 in account ***52286097",
  },
  {
    id: 16,
    label: "withdrawal transaction at Howell and Sons using card ending with ***(...2882) for BMD 483.03 in account ***28697374",
  },
  {
    id: 17,
    label: "invoice transaction at Oberbrunner, Blanda and Johns using card ending with ***(...7900) for JOD 76.64 in account ***87651272",
  },
  {
    id: 18,
    label: "withdrawal transaction at Kiehn - Anderson using card ending with ***(...3158) for BBD 335.25 in account ***92106198",
  },
  {
    id: 19,
    label: "deposit transaction at Greenfelder - Ernser using card ending with ***(...7066) for LRD 750.54 in account ***29544669",
  },
  {
    id: 20,
    label: "withdrawal transaction at Zulauf - Nikolaus using card ending with ***(...2077) for SBD 199.90 in account ***38861427",
  },
  {
    id: 21,
    label: "deposit transaction at Hudson - Pfannerstill using card ending with ***(...3641) for GHS 643.35 in account ***72019623",
  },
];

export const paymentTypes: PaymentType[] = [
  {
    name: "CB",
  },
  {
    name: "Cash",
  },
  {
    name: "Check",
  },
];

export class HttpTransactionsGateway {
  public static async getTransactions(): Promise<Transaction[]> {
    return mockTransactions;

    // @todo Api does not work
    return await axios.get('http://localhost:3000/transactions')
      .then(response => {
        return response.data;
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }

  public static async getTransaction(transactionId: number): Promise<DetailedTransaction> {
    const randomNumberBetween1And3 = Math.floor(Math.random() * 3) + 1;
    const detailedTransaction: DetailedTransaction = {
      id: mockTransactions[transactionId - 1].id,
      label: mockTransactions[transactionId - 1].label,
      amount: (Math.random() * 1000).toFixed(2),
      type_payment_id: randomNumberBetween1And3,
    };

    return detailedTransaction;

    // @todo Api does not work
    return await axios.get('http://localhost:3000/transactions')
      .then(response => {
        return response.data;
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }
}