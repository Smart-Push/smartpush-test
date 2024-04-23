import { useState } from "react";
import Header from "./components/Header";
import Transactions from "./components/Transactions";
import TransactionDetails from "./components/TransactionDetails";

function App() {
  const [selectedTransactionId, setSelectedTransactionId] = useState<number | undefined>(undefined);

  const transactionClickHandler = (transactionId: number) => {
    setSelectedTransactionId(transactionId);
  }

  return (
    <div className="flex h-screen bg-gray-50 dark:bg-gray-900">
      <div className="flex flex-col flex-1 w-full">
        <Header />
        <main className="w-full h-full overflow-y-auto">
					<div className="container grid py-6 px-6 mx-auto">
            <Transactions onTransactionClick={transactionClickHandler} />
            <TransactionDetails transactionId={selectedTransactionId}/>
          </div>
        </main>
      </div>
    </div>
  );
}

export default App;
