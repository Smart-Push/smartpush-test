import React, {useEffect, useState} from 'react';
import './App.css';
import {
  DetailedTransaction,
  HttpTransactionsGateway,
  Transaction
} from "./services/HttpTransactionsGateway";

function getPaymentType(paymentTypeId: number) {
  switch (paymentTypeId) {
    case 1:
      return 'CB';
    case 2:
      return 'Cash';
    case 3:
      return 'Check';
    default:
      return 'Unknown';
  }
}

function App() {
  const [transactions, setTransactions] = useState<Array<Transaction> | null>(null);
  
  const [filter, setFilter] = useState<string>('');
  const [filteredTransactions, setFilteredTransactions] = useState<Array<Transaction> | null>(transactions);

  const [selectedTransaction, setSelectedTransaction] = useState<DetailedTransaction | null>(null);

  useEffect(() => {
    (async () => {
      const transactions = await HttpTransactionsGateway.getTransactions();
      setTransactions(transactions);
      setFilteredTransactions(transactions);
    })();
  }, []);

  const handleFilterChange = (e: { target: { value: string; }; }) => {
    setFilter(e.target.value.toLowerCase());
    filterTransactions(e.target.value.toLowerCase());
  };

  const filterTransactions = (filterValue: string) => {
    if (!transactions){
      return;
    }

    const filtered = transactions.filter(
      (transaction) =>
        transaction.label.toLowerCase().includes(filterValue)
    );
    setFilteredTransactions(filtered);
  };

  const handleRowClick = async (transaction: Transaction) => {
    const selectedTransaction = await HttpTransactionsGateway.getTransaction(transaction.id);
    setSelectedTransaction(selectedTransaction);
  };

  return (
    <div className="container">
      <div className="container">
        <h1>Transaction Table</h1>
        <input
          type="text"
          placeholder="Filter by label"
          value={filter}
          onChange={handleFilterChange}
        />
        <table>
          <thead>
          <tr>
            <th>Id</th>
            <th>Label</th>
          </tr>
          </thead>
          <tbody>
          {filteredTransactions && filteredTransactions.map((transaction, index) => (
            <tr key={index} onClick={() => handleRowClick(transaction)}>
              <td>{transaction.id}</td>
              <td>{transaction.label}</td>
            </tr>
          ))}
          </tbody>
        </table>
        {selectedTransaction && (
          <div className="transaction-details">
            <h2>Selected Transaction Details</h2>
            <p><strong>Label:</strong> {selectedTransaction.label}</p>
            <p><strong>Amount:</strong> {selectedTransaction.amount}</p>
            <p><strong>Payment Type:</strong> {getPaymentType(selectedTransaction.type_payment_id)}</p>
          </div>
        )}
      </div>
    </div>
  );
}

export default App;
